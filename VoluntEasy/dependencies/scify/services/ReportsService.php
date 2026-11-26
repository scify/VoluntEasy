<?php namespace Dependencies\scify\services;

use Interfaces\ReportsServiceAbstract;

class ReportsService extends ReportsServiceAbstract {

    public function getViewPath() {
        return 'ekpizo.resources.views.reports.all';
    }

}
