<?php

function link_to_backend($name, $parameters = array()) {
  return sfProjectConfiguration::getActive()->generateBackendUrl($name, $parameters);
}