<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return [
    'routes'     => [
        'main'   => [
            'mautic_page_buildertoken_index' => [
                'path'       => '/pages/buildertokens/{page}',
                'controller' => 'MauticPageBundle:SubscribedEvents\BuilderToken:index'
            ],
            'mautic_page_index'              => [
                'path'       => '/pages/{page}',
                'controller' => 'MauticPageBundle:Page:index'
            ],
            'mautic_page_action'             => [
                'path'       => '/pages/{objectAction}/{objectId}',
                'controller' => 'MauticPageBundle:Page:execute'
            ],
        ],
        'public' => [
            'mautic_page_tracker'  => [
                'path'       => '/mtracking.gif',
                'controller' => 'MauticPageBundle:Public:trackingImage'
            ],
            'mautic_url_redirect' => [
                'path'       => '/r/{redirectId}',
                'controller' => 'MauticPageBundle:Public:redirect'
            ],
            'mautic_page_redirect' => [
                'path'       => '/redirect/{redirectId}',
                'controller' => 'MauticPageBundle:Public:redirect'
            ],
            'mautic_page_preview' => [
                'path'       => '/page/preview/{id}',
                'controller' => 'MauticPageBundle:Public:preview'
            ]
        ],
        'api'    => [
            'mautic_api_getpages' => [
                'path'       => '/pages',
                'controller' => 'MauticPageBundle:Api\PageApi:getEntities',
            ],
            'mautic_api_getpage'  => [
                'path'       => '/pages/{id}',
                'controller' => 'MauticPageBundle:Api\PageApi:getEntity',
            ]
        ],
        'catchall'  => [
            'mautic_page_public'   => [
                'path'       => '/{slug}',
                'controller' => 'MauticPageBundle:Public:index',
                'requirements' => [
                    'slug' => '^(?!(_(profiler|wdt)|css|images|js|favicon.ico|apps/bundles/|plugins/)).+'
                ]
            ],
        ]
    ],

    'menu' => [
        'main' => [
            'items'    => [
                'mautic.page.pages' => [
                    'route' => 'mautic_page_index',
                    'access'    => ['page:pages:viewown', 'page:pages:viewother'],
                    'parent'    => 'mautic.core.components',
                    'priority'  => 100
                ]
            ]
        ]
    ],

    'categories' => [
        'page' => null
    ],

    'services'   => [
        'events' => [
            'mautic.page.subscriber'                => [
                'class' => 'Mautic\PageBundle\EventListener\PageSubscriber'
            ],
            'mautic.pagebuilder.subscriber'         => [
                'class' => 'Mautic\PageBundle\EventListener\BuilderSubscriber',
                'arguments' => [
                    'mautic.factory',
                    'mautic.page.helper.token'
                ]
            ],
            'mautic.pagetoken.subscriber'           => [
                'class' => 'Mautic\PageBundle\EventListener\TokenSubscriber'
            ],
            'mautic.page.pointbundle.subscriber'    => [
                'class' => 'Mautic\PageBundle\EventListener\PointSubscriber'

            ],
            'mautic.page.reportbundle.subscriber'   => [
                'class' => 'Mautic\PageBundle\EventListener\ReportSubscriber'
            ],
            'mautic.page.campaignbundle.subscriber' => [
                'class' => 'Mautic\PageBundle\EventListener\CampaignSubscriber',
                'arguments' => [
                    'mautic.factory',
                    'mautic.page.model.page',
                    'mautic.campaign.model.event'
                ]
            ],
            'mautic.page.leadbundle.subscriber'     => [
                'class'       => 'Mautic\PageBundle\EventListener\LeadSubscriber',
            ],
            'mautic.page.calendarbundle.subscriber' => [
                'class' => 'Mautic\PageBundle\EventListener\CalendarSubscriber'
            ],
            'mautic.page.configbundle.subscriber'   => [
                'class' => 'Mautic\PageBundle\EventListener\ConfigSubscriber'
            ],
            'mautic.page.search.subscriber'         => [
                'class' => 'Mautic\PageBundle\EventListener\SearchSubscriber'
            ],
            'mautic.page.webhook.subscriber'        => [
                'class' => 'Mautic\PageBundle\EventListener\WebhookSubscriber'
            ],
            'mautic.page.dashboard.subscriber'      => [
                'class' => 'Mautic\PageBundle\EventListener\DashboardSubscriber'
            ],
            'mautic.page.js.subscriber'           => [
                'class' => 'Mautic\PageBundle\EventListener\BuildJsSubscriber'
            ]
        ],
        'forms'  => [
            'mautic.form.type.page'                     => [
                'class'     => 'Mautic\PageBundle\Form\Type\PageType',
                'arguments' => 'mautic.factory',
                'alias'     => 'page'
            ],
            'mautic.form.type.pagevariant'              => [
                'class'     => 'Mautic\PageBundle\Form\Type\VariantType',
                'arguments' => 'mautic.factory',
                'alias'     => 'pagevariant'
            ],
            'mautic.form.type.pointaction_pointhit'     => [
                'class' => 'Mautic\PageBundle\Form\Type\PointActionPageHitType',
                'alias' => 'pointaction_pagehit'
            ],
            'mautic.form.type.pointaction_urlhit'       => [
                'class' => 'Mautic\PageBundle\Form\Type\PointActionUrlHitType',
                'alias' => 'pointaction_urlhit'
            ],
            'mautic.form.type.pagehit.campaign_trigger' => [
                'class' => 'Mautic\PageBundle\Form\Type\CampaignEventPageHitType',
                'alias' => 'campaignevent_pagehit'
            ],
            'mautic.form.type.pagelist'                 => [
                'class'     => 'Mautic\PageBundle\Form\Type\PageListType',
                'arguments' => 'mautic.factory',
                'alias'     => 'page_list',
            ],
            'mautic.form.type.page_abtest_settings'     => [
                'class' => 'Mautic\PageBundle\Form\Type\AbTestPropertiesType',
                'alias' => 'page_abtest_settings'
            ],
            'mautic.form.type.page_publish_dates'       => [
                'class' => 'Mautic\PageBundle\Form\Type\PagePublishDatesType',
                'alias' => 'page_publish_dates'
            ],
            'mautic.form.type.pageconfig'               => [
                'class' => 'Mautic\PageBundle\Form\Type\ConfigType',
                'alias' => 'pageconfig'
            ],
            'mautic.form.type.slideshow_config'         => [
                'class' => 'Mautic\PageBundle\Form\Type\SlideshowGlobalConfigType',
                'alias' => 'slideshow_config'
            ],
            'mautic.form.type.slideshow_slide_config'   => [
                'class' => 'Mautic\PageBundle\Form\Type\SlideshowSlideConfigType',
                'alias' => 'slideshow_slide_config'
            ],
            'mautic.form.type.redirect_list'            => [
                'class' => 'Mautic\PageBundle\Form\Type\RedirectListType',
                'arguments' => 'mautic.factory',
                'alias' => 'redirect_list'
            ],
            'mautic.form.type.page_dashboard_hits_in_time_widget' => [
                'class' => 'Mautic\PageBundle\Form\Type\DashboardHitsInTimeWidgetType',
                'alias' => 'page_dashboard_hits_in_time_widget'
            ]
        ],
        'models' =>  [
            'mautic.page.model.page' => [
                'class' => 'Mautic\PageBundle\Model\PageModel',
                'arguments' => [
                    'mautic.helper.cookie',
                    'mautic.helper.ip_lookup',
                    'mautic.lead.model.lead',
                    'mautic.lead.model.field',
                    'mautic.page.model.redirect',
                    'mautic.page.model.trackable'
                ],
                'methodCalls' => [
                    'setCatInUrl' => [
                        '%mautic.cat_in_page_url%'
                    ]
                ]
            ],
            'mautic.page.model.redirect' => [
                'class' => 'Mautic\PageBundle\Model\RedirectModel'
            ],
            'mautic.page.model.trackable' => [
                'class' => 'Mautic\PageBundle\Model\TrackableModel',
                'arguments' => [
                    'mautic.page.model.redirect'
                ]
            ]
        ],
        'other' => [
            'mautic.page.helper.token' => [
                'class'     => 'Mautic\PageBundle\Helper\TokenHelper',
                'arguments' => 'mautic.page.model.page'
            ]
        ]
    ],

    'parameters' => [
        'cat_in_page_url'  => false,
        'google_analytics' => false,

        'redirect_list_types' => [
            '301' => 'mautic.page.form.redirecttype.permanent',
            '302' => 'mautic.page.form.redirecttype.temporary'
        ]
    ]
];
