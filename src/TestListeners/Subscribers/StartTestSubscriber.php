<?php

namespace Yoast\PHPUnitPolyfills\TestListeners\Subscribers;

use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;

/**
 * Event subscriber.
 *
 * @since 2.0.0
 */
final class StartTestSubscriber implements PreparedSubscriber {

	/**
	 * Subscriber constructor.
	 *
	 * @param Handler $handler Instance of the class which composes a "test listener".
	 */
	public function __construct( private readonly Handler $handler ) {}

	/**
	 * Trigger the test listener method equivalent to this event.
	 *
	 * @param Prepared $event The event object.
	 */
	public function notify( Prepared $event ): void {
		$this->handler->startTest(
			$event->test(),
			$event->telemetryInfo()->time()
		);
	}
}
