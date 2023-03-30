<?php

namespace Yoast\PHPUnitPolyfills\TestListeners\Subscribers;

use PHPUnit\Event\Test\ConsideredRisky;
use PHPUnit\Event\Test\ConsideredRiskySubscriber;

/**
 * Event subscriber.
 *
 * @since 2.0.0
 */
final class AddRiskySubscriber implements ConsideredRiskySubscriber {

	/**
	 * Subscriber constructor.
	 *
	 * @param object $handler Instance of the class which functions as the "test listener".
	 */
	public function __construct( private readonly object $handler ) {}

	/**
	 * Trigger the test listener method equivalent to this event.
	 *
	 * @param ConsideredRisky $event The event object.
	 */
	public function notify( ConsideredRisky $event ): void {
		$this->handler->addRiskyTest(
			$event->test(),
			$event->throwable(),
			$event->telemetryInfo()->time()
		);
	}
}
