<?php

namespace Jourdon\Sluggable\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class JourdonMakeSlug extends GeneratorCommand
{

    protected $signature = 'jourdon:make_slug {name}';

    protected $description = '为你的存在的模型添加Slug字段';

    protected function getStub()
    {
        return __DIR__.'/../../database/stubs/add_slug_to_TableName_tables.stub';
    }
    
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }
    protected function getPath($name)
    {
        return database_path().'/migrations/'.date('Y_m_d_His', time()).'_'.$this->getStubName($name);
    }
    protected function getStubName($name)
    {
        $fileName = trim(strrchr($this->getStub(), '/'),'/');
        $fileName = str_replace('TableName', $this->getTableName($name), $fileName);
        $fileName = str_replace('stub', 'php', $fileName);
        return $fileName;
    }
    protected function getTableName($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return lcfirst(str_plural($name));
    }
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $stub = str_replace('{{TableName}}', lcfirst(str_plural($class)), $stub);
        return str_replace('DummyClass', str_plural($class), $stub);
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