<?php

namespace Yoast\PHPUnitPolyfills\TestListeners\Subscribers;

use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\ErroredSubscriber;

/**
 * Event subscriber.
 *
 * @since 2.0.0
 */
final class AddErrorSubscriber implements ErroredSubscriber {

	/**
	 * Subscriber constructor.
	 *
	 * @param Handler $handler Instance of the class which composes a "test listener".
	 */
	public function __construct( private readonly Handler $handler ) {}

	/**
	 * Trigger the test listener method equivalent to this event.
	 *
	 * @param Errored $event The event object.
	 */
	public function notify( Errored $event ): void {
		$this->handler->addError(
			$event->test(),
			$event->throwable(),
			$event->telemetryInfo()->time()
		);
	}
}
