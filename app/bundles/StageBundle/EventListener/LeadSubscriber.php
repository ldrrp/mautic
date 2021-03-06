<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\StageBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\LeadBundle\Event\LeadEvent;
use Mautic\LeadBundle\Event\LeadMergeEvent;
use Mautic\LeadBundle\Event\LeadTimelineEvent;
use Mautic\LeadBundle\Event\StagesChangeEvent;
use Mautic\LeadBundle\LeadEvents;

/**
 * Class LeadSubscriber
 */
class LeadSubscriber extends CommonSubscriber
{

    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            LeadEvents::TIMELINE_ON_GENERATE => array('onTimelineGenerate', 0),
            LeadEvents::LEAD_POST_MERGE      => array('onLeadMerge', 0),
            LeadEvents::LEAD_POST_SAVE       => array('onLeadSave', -1)
        );
    }

    /**
     * Compile events for the lead timeline
     *
     * @param LeadTimelineEvent $event
     */
    public function onTimelineGenerate(LeadTimelineEvent $event)
    {
        // Set available event types
        $eventTypeKey = 'stage.changed';
        $eventTypeName = $this->translator->trans('mautic.stage.event.changed');
        $event->addEventType($eventTypeKey, $eventTypeName);

        $filters = $event->getEventFilters();

        if (!$event->isApplicable($eventTypeKey)) {
            return;
        }

        $lead    = $event->getLead();
        $options = array('ipIds' => array(), 'filters' => $filters);

        /** @var \Mautic\PageBundle\Entity\HitRepository $hitRepository */
        $logRepository = $this->factory->getEntityManager()->getRepository('MauticLeadBundle:StagesChangeLog');

        $logs = $logRepository->getLeadTimelineEvents($lead->getId(), $options);

        // Add the logs to the event array
        foreach ($logs as $log) {
            $event->addEvent(array(
                'event'           => $eventTypeKey,
                'eventLabel'      => $eventTypeName,
                'timestamp'       => $log['dateAdded'],
                'extra'           => array(
                    'log'           => $log
                ),
                'contentTemplate' => 'MauticStageBundle:SubscribedEvents\Timeline:index.html.php',
                'icon'            => 'fa-tachometer'
            ));
        }
    }

    /**
     * @param LeadChangeEvent $event
     */
    public function onLeadMerge(LeadMergeEvent $event)
    {
        $em = $this->factory->getEntityManager();
        $em->getRepository('MauticStageBundle:LeadStageLog')->updateLead(
            $event->getLoser()->getId(),
            $event->getVictor()->getId()
        );
    }

    /**
     * Handle for new leads 
     *
     * @param LeadEvent $event
     */
    public function onLeadSave(LeadEvent $event)
    {
        
    }
}
