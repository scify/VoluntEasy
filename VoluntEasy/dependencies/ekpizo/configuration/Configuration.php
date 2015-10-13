<?php namespace Dependencies\ekpizo\configuration;


use Interfaces\ConfigurationInterface;

class Configuration implements ConfigurationInterface {


    function getPartialLoginFooterPath() {

        return 'ekpizo.resources.views._login_footer';
    }
}
