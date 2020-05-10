<?php

namespace Hgg\HttpManager;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @method static Event dispatch(Event $event) Dispatches an event to all registered listeners
 * @method static array getListeners($eventName = null) Gets the listeners of a specific event or all listeners sorted by descending priority.
 * @method static int|void getListenerPriority($eventName, $listener) Gets the listener priority for a specific event.
 * @method static bool hasListeners($eventName = null) Checks whether an event has any registered listeners.
 * @method static void addListener($eventName, $listener, $priority = 0) Adds an event listener that listens on the specified events.
 * @method static void addSubscriber(EventSubscriberInterface $subscriber) Adds an event subscriber.
 * @method static void removeSubscriber(EventSubscriberInterface $subscriber)
 */
class Events
{
    /**
     * dispatcher.
     *
     * @var EventDispatcher
     */
    protected static $dispatcher = false;

    public static function removeListener($eventName, $methodName)
    {
        $listeners = self::getDispatcher()->getListeners($eventName);

        foreach ($listeners as $key => $value) {
            if ($value[1] == $methodName) {
                return call_user_func_array([self::getDispatcher(), "removeListener"], [$eventName, $value]);
            }
        }
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::getDispatcher(), $method], $args);
    }

    public function __call($method, $args)
    {
        return call_user_func_array([self::getDispatcher(), $method], $args);
    }

    public static function initDispatcher()
    {
        self::$dispatcher = new EventDispatcher();
    }

    public static function getDispatcher(): EventDispatcher
    {
        if (self::$dispatcher) {
            return self::$dispatcher;
        }

        return self::$dispatcher = new EventDispatcher();
    }
}
