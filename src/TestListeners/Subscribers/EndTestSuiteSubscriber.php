<?php

namespace Yoast\PHPUnitPolyfills\TestListeners\Subscribers;

use PHPUnit\Event\TestSuite\Finished;
use PHPUnit\Event\TestSuite\FinishedSubscriber;

/**
 * Event subscriber.
 *
 * @since 2.0.0
 */
final class EndTestSuiteSubscriber implements FinishedSubscriber {

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
		$this->handler->endTestSuite(
			$event->testSuite()
		);
	}
}
