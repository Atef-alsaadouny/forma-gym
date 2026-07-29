<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    private const ROUTES = [
        '/' => 'home',
        '/crossfit' => 'crossfit',
        '/faq' => 'faq',
        '/rules' => 'rules',
        '/subscription/register' => 'subscription.register',
        '/subscription/lookup' => 'subscription.lookup',
    ];

    public function __invoke(): Response
    {
        $xml = $this->buildXml();

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    private function buildXml(): string
    {
        $host = config('app.url', url('/'));
        $lastMod = now()->format('Y-m-d');
        $locales = ['ar', 'en'];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach (self::ROUTES as $path => $name) {
            $loc = $host.$path;
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($loc).'</loc>'."\n";
            $xml .= '    <lastmod>'.$lastMod.'</lastmod>'."\n";
            $xml .= '    <changefreq>'.($path === '/' ? 'daily' : 'weekly').'</changefreq>'."\n";
            $xml .= '    <priority>'.($path === '/' ? '1.0' : '0.8').'</priority>'."\n";

            foreach ($locales as $locale) {
                $alternateUrl = $path === '/'
                    ? $host.'/locale/'.$locale
                    : $host.$path.'?locale='.$locale;
                $xml .= '    <xhtml:link rel="alternate" hreflang="'.$locale.'" href="'.htmlspecialchars($alternateUrl).'" />'."\n";
            }

            $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="'.htmlspecialchars($loc).'" />'."\n";
            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
