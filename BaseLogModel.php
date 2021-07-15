<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

abstract class BaseLogModel extends \BasicApp\Model\BaseModel implements LoggerInterface
{

    use LoggerTrait;

    protected $returnType = 'BasicApp\Log\LogEntity';

    protected $primaryKey = 'id';

    protected $allowedFields = ['level', 'message', 'context'];

    protected $defaultContext;

    public function setDefaultContext(array $context)
    {
        $this->defaultContext = $context;
    }

    public function log($level, $message, array $context = [])
    {
        $params = [
            'level' => $level,
            'message' => $message
        ];

        if ($this->defaultContext)
        {
            $context = array_merge($this->defaultContext, $context);
        }

        foreach($context as $key => $value)
        {
            if ($key == $this->primaryKey)
            {
                continue;
            }

            if (array_search($key, $this->allowedFields) !== false)
            {
                $params[$key] = $value;

                unset($context[$key]);
            }
        }

        $params['context'] = $context;

        $entity = $this->createEntity($params);

        $this->insert($entity);
    
        return $this->insertID;
    }

}