<?php

namespace Yoast\PHPUnitPolyfills\TestListeners\Subscribers;

use PHPUnit\Event\Test\Finished;
use PHPUnit\Event\Test\FinishedSubscriber;

/**
 * Event subscriber.
 *
 * @since 2.0.0
 */
final class EndTestSubscriber implements FinishedSubscriber {

	/**
	 * Subscriber constructor.
	 *
	 * @param Handler $handler Instance of the class which composes a "test listener".
	 */
	public function __construct( private readonly Handler $handler ) {}

	/**
	 * Trigger the test listener method equivalent to this event.
	 *
	 * @param Finished $event The event object.
	 */
	public function notify( Finished $event ): void {
		$this->handler->startTest(
			$event->test(),
			$event->telemetryInfo()->time()
		);
	}
}
