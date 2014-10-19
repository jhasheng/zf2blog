<?php
namespace JhaAdmin\View\Helper;

use Zend\View\Helper\AbstractHelper;

class JhaDate extends AbstractHelper
{

    const TIME_AUTO = 'auto';

    const TIME_NORMAL = 'normal';

    const TIME_FORMAT = 'Y-m-d H:i';

    public function __invoke($timestamp, $type = NULL, $format = NULL)
    {
        if (is_null($type)) {
            $type = self::TIME_AUTO;
        }
        
        if (is_null($format)) {
            $format = self::TIME_FORMAT;
        }
        
        switch ($type) {
            case self::TIME_NORMAL:
                return date($format, $timestamp);
            case self::TIME_AUTO:
                $time = new \DateTime();
                $time->setTimestamp($timestamp);
                $diff = $time->diff(new \DateTime());
//                 var_dump($diff);
                if ($diff->format('%y') || $diff->format('%m')){
                    return date($format, $timestamp);
                }else{
                    if ($diff->format('%d')) {
                        return $time->diff(new \DateTime())->format('%d天前');
                    } elseif ($diff->format('%h')) {
                        return $time->diff(new \DateTime())->format('%h小时前');
                    } elseif ($diff->format('%i')) {
                        return $time->diff(new \DateTime())->format('%i分钟前');
                    } elseif ($diff->format('%s')) {
                        return $time->diff(new \DateTime())->format('%s秒前');
                    } 
                }            
            default:
                return date($format, $timestamp);
        }
    }
}