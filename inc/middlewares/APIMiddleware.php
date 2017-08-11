<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class APIMiddleware extends Middleware
{

  public function handle()
  {
    Api::updateStats();
  }
}
