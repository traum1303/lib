<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');

        if (empty($name)) {
            $name = $this->ask('Enter service name (e.g. User or User/Profile)');
        }

        if (empty($name)) {
            $this->error('Service name is required!');
            return self::FAILURE;
        }

        $name = str_replace(['\\', '.'], '/', $name);

        $segments = collect(explode('/', $name))
            ->map(fn ($part) => Str::studly($part))
            ->filter()
            ->values();

        $className = $segments->pop();

        if (! Str::endsWith($className, 'Service')) {
            $className .= 'Service';
        }

        $subNamespace = $segments->implode('\\');
        $basePath = app_path('Services');
        $directory = $basePath . ($segments->isNotEmpty() ? '/' . $segments->implode('/') : '');

        if (! $this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $namespace = 'App\\Services' . ($subNamespace ? '\\' . $subNamespace : '');
        $filePath = $directory . '/' . $className . '.php';

        if ($this->files->exists($filePath)) {
            $this->error('Service already exists!');
            return self::FAILURE;
        }

        $stub = <<<PHP
<?php declare(strict_types=1);

namespace {$namespace};

class {$className}
{
    public function __construct()
    {
        //
    }

    public function handle()
    {
        //
    }
}
PHP;

        $this->files->put($filePath, $stub);

        $this->info("Service {$namespace}\\{$className} created successfully.");

        return self::SUCCESS;
    }
}
