<?php

namespace Jourdon\Sluggable\Traits;

use Cache;
use Artisan;
use Jourdon\Sluggable\Jobs\TranslateSlug;

trait SlugTrait
{
    protected $expire_id = 3660;

    public static function bootSlugTrait()
    {
        static::saving(function ($model) {
            return $model->chengSlug();
        });
    }
    
    public function getSlugAttribute($value)
    {
        if (!$value) {
            dispatch(new TranslateSlug($this));
        }
        return $value;
    }

    public function getRouteKey()
    {
        if (!$this->slug) {
            return $this->id;
        }
        return $this->slug;
    }
    
    public function resolveRouteBinding($value)
    {
        $id=Cache::get($this->getTable().'_'.$value,function()use ($value){
            Artisan::call('jourdon:'.str_singular($this->getTable()).'-slug-cache',['--queue' => 'default']);
            return self::where('slug',$value)->pluck('id')->first();
        });
        if(!$id) {
            return parent::resolveRouteBinding($value);
        }
        return parent::resolveRouteBinding($id);
    }

    public function SlugCache()
    {
        $expire_id = $this->expire_id;
        $data = $this::select('slug','id')->get();
        $data->filter(function($item) use ($expire_id){
            Cache::put($item->getTable().'_'.$item->slug,$item->id,$expire_id);
        });
    }

    protected function chengSlug()
    {
        if(!$this->slug ||$this->getOriginal('title')!=$this->title){
            //推送任到进队列
            dispatch(new TranslateSlug($this));
        }
    }
}