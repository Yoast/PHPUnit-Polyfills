<?php

namespace Yoast\PHPUnitPolyfills\TestListeners\Subscribers;

use PHPUnit\Event\Test\WarningTriggered;
use PHPUnit\Event\Test\WarningTriggeredSubscriber;

/**
 * Event subscriber.
 *
 * @since 2.0.0
 */
final class AddWarningSubscriber implements WarningTriggeredSubscriber {

	/**
	 * Subscriber constructor.
	 *
	 * @param object $handler Instance of the class which functions as the "test listener".
	 */
	public function __construct( private readonly object $handler ) {}

	/**
	 * Trigger the test listener method equivalent to this event.
	 *
	 * @param WarningTriggered $event The event object.
	 */
	public function notify( WarningTriggered $event ): void {
		$this->handler->addWarning(
			$event->test(),
//            $event->throwable(),
			$event->telemetryInfo()->time()
		);
	}
}
