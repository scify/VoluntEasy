<?php namespace Dependencies\ekpizo\configuration;


use Interfaces\VoluntEasyConfigurationInterface;

class VoluntEasyConfigurationImpl implements VoluntEasyConfigurationInterface {


    function getPartialLoginFooterPath() {

        return 'ekpizo.resources.views._login_footer';
    }
}
