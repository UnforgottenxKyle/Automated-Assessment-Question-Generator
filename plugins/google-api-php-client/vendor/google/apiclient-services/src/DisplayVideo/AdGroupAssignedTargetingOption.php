<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\DisplayVideo;

class AdGroupAssignedTargetingOption extends \Google\Model
{
  /**
   * @var string
   */
  public $adGroupId;
  /**
   * @var AssignedTargetingOption
   */
  public $assignedTargetingOption;
  protected $assignedTargetingOptionType = AssignedTargetingOption::class;
  protected $assignedTargetingOptionDataType = '';

  /**
   * @param string
   */
  public function setAdGroupId($adGroupId)
  {
    $this->adGroupId = $adGroupId;
  }
  /**
   * @return string
   */
  public function getAdGroupId()
  {
    return $this->adGroupId;
  }
  /**
   * @param AssignedTargetingOption
   */
  public function setAssignedTargetingOption(AssignedTargetingOption $assignedTargetingOption)
  {
    $this->assignedTargetingOption = $assignedTargetingOption;
  }
  /**
   * @return AssignedTargetingOption
   */
  public function getAssignedTargetingOption()
  {
    return $this->assignedTargetingOption;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AdGroupAssignedTargetingOption::class, 'Google_Service_DisplayVideo_AdGroupAssignedTargetingOption');
