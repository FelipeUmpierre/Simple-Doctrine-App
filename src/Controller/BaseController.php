<?php

namespace Controller;

use Configurations\ConfigurationsTrait;
use Configurations\SecurityTrait;

/**
 * Class BaseController
 *
 * @package Controller
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
abstract class BaseController
{
    use ConfigurationsTrait, SecurityTrait;
}