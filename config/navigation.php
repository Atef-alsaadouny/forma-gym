<?php

declare(strict_types=1);

return [

    'sidebar' => [
        [
            'label' => 'Members',
            'route' => 'admin.members.index',
            'icon' => 'users',
            'roles' => ['owner', 'admin', 'manager', 'receptionist'],
        ],

        [
            'label' => 'Trainers',
            'route' => 'admin.trainers.index',
            'icon' => 'academic-cap',
            'roles' => ['owner', 'admin', 'manager'],
        ],

        [
            'label' => 'Memberships',
            'route' => 'admin.packages.index',
            'icon' => 'tag',
            'roles' => ['owner', 'admin', 'manager'],
        ],

        [
            'label' => 'Subscriptions',
            'route' => 'admin.subscriptions.index',
            'icon' => 'credit-card',
            'roles' => ['owner', 'admin', 'manager', 'receptionist'],
        ],

        [
            'label' => 'Public Registrations',
            'route' => 'admin.subscriptions.public',
            'icon' => 'user-plus',
            'roles' => ['owner', 'admin', 'manager', 'receptionist'],
        ],

        [
            'label' => 'Attendance',
            'route' => 'admin.attendance.index',
            'icon' => 'clipboard-check',
            'roles' => ['owner', 'admin', 'manager', 'receptionist'],
        ],

        [
            'label' => 'Workout Plans',
            'route' => 'admin.workout-plans.index',
            'icon' => 'collection',
            'roles' => ['owner', 'admin', 'manager', 'trainer'],
        ],

        [
            'label' => 'Reports',
            'route' => 'admin.reports.index',
            'icon' => 'chart-bar-square',
            'roles' => ['owner', 'admin', 'manager'],
        ],

        [
            'label' => 'Branches',
            'route' => 'admin.branches.index',
            'icon' => 'building-storefront',
            'roles' => ['owner', 'admin'],
        ],

        [
            'label' => 'Settings',
            'route' => 'admin.settings.index',
            'icon' => 'cog-6-tooth',
            'roles' => ['owner', 'admin'],
        ],
    ],

];
