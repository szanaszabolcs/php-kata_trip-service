<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;

class TripServiceTest extends TestCase
{
    private TripService $tripService;

    protected function setUp(): void
    {
        $this->tripService = new TripService;
    }

    public function test_get_trips_by_user_with_unauthenticated_user(): void
    {
        $this->expectException(UserNotLoggedInException::class);

        $user = $this->createMock(User::class);
        $userSession = $this->getMockBuilder(UserSession::class)->getMock();
        $userSession->expects($this->once())
                    ->method('getLoggedUser')
                    ->willReturn(false);

        $this->setUserSessionReflection($userSession);

        $this->tripService->getTripsByUser($user);
    }

    private function setUserSessionReflection($userSession): void
    {
        $userSessionReflection = new ReflectionClass(UserSession::class);
        $userSessionReflection->setStaticPropertyValue('userSession', $userSession);
    }
}
