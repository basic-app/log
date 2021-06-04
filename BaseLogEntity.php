<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Log;

abstract class BaseLogEntity extends \BasicApp\Entity\BaseEntity
{

    protected $casts = [
        'context' => 'json-array'
    ];

}