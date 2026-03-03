<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'title' => 'DhisLab E-Commerce',
            'description' => 'A robust e-commerce platform built with Lumen and MySQL.',
            'preview' => 'https://via.placeholder.com/600x400?text=E-Commerce'
        ]);

        Project::create([
            'title' => 'Smart Dashboard',
            'description' => 'Real-time monitoring dashboard with Redis caching.',
            'preview' => 'https://via.placeholder.com/600x400?text=Dashboard'
        ]);

        Project::create([
            'title' => 'Social Connect',
            'description' => 'A micro-social media API focusing on high performance.',
            'preview' => 'https://via.placeholder.com/600x400?text=Social+API'
        ]);
    }
}
