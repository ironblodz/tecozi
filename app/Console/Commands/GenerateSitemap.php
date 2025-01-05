<?php

namespace App\Console\Commands;

use App\Models\Portfolio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url as SitemapUrl; // Evita conflito com o facade URL

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap for the website';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Força o uso de HTTPS e do domínio correto
        URL::forceScheme('https');
        URL::forceRootUrl(config('app.url'));

        $sitemap = Sitemap::create();

        // Adicione páginas estáticas
        $sitemap->add(SitemapUrl::create('/')->setPriority(1.0)->setChangeFrequency('daily'))
                ->add(SitemapUrl::create('/about')->setPriority(0.8)->setChangeFrequency('monthly'))
                ->add(SitemapUrl::create('/services')->setPriority(0.8)->setChangeFrequency('monthly'))
                ->add(SitemapUrl::create('/materials')->setPriority(0.8)->setChangeFrequency('monthly'))
                ->add(SitemapUrl::create('/contacts')->setPriority(0.8)->setChangeFrequency('monthly'))
                ->add(SitemapUrl::create('/portfolio')->setPriority(0.8)->setChangeFrequency('monthly'))
                ->add(SitemapUrl::create('/privacy')->setPriority(0.5)->setChangeFrequency('yearly'))
                ->add(SitemapUrl::create('/resolution')->setPriority(0.5)->setChangeFrequency('yearly'));

        // Adicione páginas dinâmicas de portfólios
        $portfolios = Portfolio::all();
        foreach ($portfolios as $portfolio) {
            $sitemap->add(
                SitemapUrl::create("/portfolio/{$portfolio->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($portfolio->updated_at)
            );
        }

        // Escreva o sitemap no arquivo
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap gerado com sucesso!');
    }
}
