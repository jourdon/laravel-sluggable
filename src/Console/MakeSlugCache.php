<?php

namespace Jourdon\Sluggable\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeSlugCache extends GeneratorCommand
{

    protected $signature = 'jourdon:make_cache {name}';

    protected $description = '将你的Slug加入缓存';

    protected function getStub()
    {
        return __DIR__.'/../../console/stubs/TableNameSlugCache.stub';
    }
    
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }
    protected function getPath($name)
    {
        return app_path().'/Console/Commands/'.$this->getStubName($name);
    }
    protected function getStubName($name)
    {
        $fileName = trim(strrchr($this->getStub(), '/'),'/');
        $fileName = str_replace(['TableName','stub'], [$this->getTableName($name),'php'], $fileName);
        return $fileName;
    }
    protected function getTableName($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $name = trim(strrchr($name, '\\'),'\\');
        return $name;
    }
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $stub = str_replace('{{TableName}}', lcfirst($class), $stub);
        return str_replace('DummyClass', $class, $stub);
    }
    
    //public function handle()
    //{
    //    $this->call('make:migration', [
    //        'add_slug_to_users_table'=>'true','--table=users' => 'true'
    //    ]);
    //    //dd(__DIR__.'/database/stubs/2016_01_04_173148_add_slug_to_TableName_tables.stub');
    //    //dump('到这里了？');
    //}
}