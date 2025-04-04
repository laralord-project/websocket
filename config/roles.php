<?php

use App\Models\Role as Role;

return [
    /**
     * Base roles and permissions map
     *
     */
    Role::SUPER_ADMIN => [
        'display_name' => 'Super Admin',
        'permissions' => 'all',
    ],

    Role::ADMIN => [
        'display_name' => 'Admin',
        'permissions' => [
            'users.*' => [
                'display_name' => 'Users all actions'
            ],
            'roles.*' => [
                'display_name' => 'Roles all actions'
            ],
            'permissions.*' => [
                'display_name' => 'Permissions all actions'
            ],
            'company.*' => [
                'display_name' => 'Company all actions'
            ],
            'branches.*' => [
                'display_name' => 'orders all actions'
            ],
            'kitchen.*' => [
                'display_name' => 'Kitchen all actions'
            ],
            'kitchen_zone.*' => [
                'display_name' => 'Kitchen\'s zones all actions'
            ],
            'pos.*' => [
                'display_name' => 'POS all actions'
            ],
            'orders.*' => [
                'display_name' => 'orders all actions'
            ],
        ]
    ],
    Role::COMPANY_ADMIN => [
        'display_name' => 'Company Admin',
        'permissions' => [
            'company.id.users.*' => [
                'display_name' => 'Company users all actions'
            ],
            'company.id.roles.*' => [
                'display_name' => 'Company Roles all actions'
            ],
            'company.id.permissions.*' => [
                'display_name' => 'Permissions all actions'
            ],
            'company.id.read,update' => [
                'display_name' => 'Self company read, update'
            ],
            'company.id.branches.*' => [
                'display_name' => 'orders all actions'
            ],
            'company.id.kitchen.*' => [
                'display_name' => 'Kitchen all actions'
            ],
            'company.id.kitchen_zone.*' => [
                'display_name' => 'Kitchen\'s zones all actions'
            ],
            'company.id.pos.*' => [
                'display_name' => 'POS all actions'
            ],
            'company.id.pos_category.*' => [
                'display_name' => 'POS\'s categories all actions'
            ],
            'company.id.ingredient.*' => [
                'display_name' => 'POS ingredients'
            ],
            'company.id.ingredient_category.*' => [
                'display_name' => 'POS ingredient\'s categories all actions'
            ],
            'company.id.orders.*' => [
                'display_name' => 'Orders all statuses, all actions'
            ],
        ]
    ],
//    Role::ORDER_PROCESSING => [
//        'display_name' => 'Order Processing',
//        'permissions' => [
//            'company.id.branches.read,list' => [
//                'display_name' => 'Branches readonly'
//            ],
//            'company.id.orders.*' => [
//                'display_name' => 'Company orders all'
//            ],
//            'company.id.ingredient.read,list' => [
//                'display_name' => 'POS ingredients read only'
//            ],
//            'company.id.pos.read,list' => [
//                'display_name' => 'POS read only'
//            ],
//            'company.id.kitchen.read,list' => [
//                'display_name' => 'Kitchen readonly'
//            ],
//            'company.id.kitchen_zone.*' => [
//                'display_name' => 'Kitchen\'s zones all actions'
//            ],
//        ]
//    ],
//    Role::KITCHEN_OPERATOR => [
//        'display_name' => 'Kitchen operator',
//        'permissions' => [
//            'company.id.branches.read,list' => [
//                'display_name' => 'Branches readonly'
//            ],
//            'company.id.read' => [
//                'display_name' => 'Branches readonly'
//            ],
//            'company.id.ingredient.read,list' => [
//                'display_name' => 'POS ingredients read only'
//            ],
//            'company.id.pos.read,list' => [
//                'display_name' => 'POS read only'
//            ],
//            'company.id.kitchen.read,list' => [
//                'display_name' => 'Kitchen readonly'
//            ],
//            'company.id.kitchen_zone.*' => [
//                'display_name' => 'Kitchen\'s zones all actions'
//            ],
//        ]
//    ],

];
