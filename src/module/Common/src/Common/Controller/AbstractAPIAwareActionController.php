<?php
namespace Common\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AbstractAPIAwareActionController extends AbstractActionController
{
    protected function setupAPI()
    {
        $fullWidth = $this->setupAPIQueryParam('fullWidth');
        $hideTopbar = $this->setupAPIQueryParam('hideTopbar');
        $hideLeftSidebar = $this->setupAPIQueryParam('hideLeftSidebar');
        $hideRightSidebar = $this->setupAPIQueryParam('hideRightSidebar');
        $hideBreadcrumbs = $this->setupAPIQueryParam('hideBreadcrumbs');
        $hideDiscussions = $this->setupAPIQueryParam('hideDiscussions');
        $hideBanner = $this->setupAPIQueryParam('hideBanner');
        $hideHorizon = $this->setupAPIQueryParam('hideHorizon');
        $hideFooter = $this->setupAPIQueryParam('hideFooter');
        $contentOnly = $this->setupAPIQueryParam('contentOnly');

        $this->layout()->fullWidth = $fullWidth || $contentOnly;
        $this->layout()->hideTopbar = $hideTopbar || $contentOnly;
        $this->layout()->hideLeftSidebar = $hideLeftSidebar || $contentOnly;
        $this->layout()->hideRightSidebar = $hideRightSidebar || $contentOnly;
        $this->layout()->hideBreadcrumbs = $hideBreadcrumbs;
        $this->layout()->hideDiscussions = $hideDiscussions || $contentOnly;
        $this->layout()->hideBanner = $hideBanner || $contentOnly;
        $this->layout()->hideHorizon = $hideHorizon || $contentOnly;
        $this->layout()->hideFooter = $hideFooter || $contentOnly;

        $this->layout()->usingAPI = $fullWidth
            || $hideTopbar
            || $hideLeftSidebar
            || $hideRightSidebar
            || $hideBreadcrumbs
            || $hideDiscussions
            || $hideBanner
            || $hideHorizon
            || $hideFooter
            || $contentOnly;
    }

    private function setupAPIQueryParam(string $key)
    {
        return is_string($this->params()->fromQuery($key));
    }
}
