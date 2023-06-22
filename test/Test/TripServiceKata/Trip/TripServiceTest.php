<?php

namespace Test\TripServiceKata\Trip;

use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\TripDAO;
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
        $this->mockUserSession(null);

        $this->tripService->getTripsByUser($user);
    }

    public function test_get_trips_by_user_when_user_is_not_friend(): void
    {
        $user = $this->mockUser([]);
        $loggedInUser = $this->createMock(User::class);
        $this->mockUserSession($loggedInUser);

        $tripList = $this->tripService->getTripsByUser($user);

        $this->assertEquals([], $tripList);
    }

    public function test_get_trips_by_user_when_user_is_friend(): void
    {
        $loggedInUser = $this->createMock(User::class);
        $this->mockUserSession($loggedInUser);
        $user = $this->mockUser([$loggedInUser]);

        $tripDaoClass = TripDAO::class;
        $tripDao = Mockery::mock("alias:$tripDaoClass");
        $tripDao->shouldReceive('findTripsByUser')->andReturn(['trip-1', 'trip-2']);

        $tripList = $this->tripService->getTripsByUser($user);

        $this->assertEquals(['trip-1', 'trip-2'], $tripList);
    }

    private function mockUserSession(?User $getLoggedUser): void
    {
        $userSession = $this->getMockBuilder(UserSession::class)->getMock();
        $userSession->expects($this->once())
            ->method('getLoggedUser')
            ->willReturn($getLoggedUser);

        $userSessionReflection = new ReflectionClass(UserSession::class);
        $userSessionReflection->setStaticPropertyValue('userSession', $userSession);
    }

    private function mockUser(?array $getFriends): User
    {
        $user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->getMock();
        $user->expects($this->once())
            ->method('getFriends')
            ->willReturn($getFriends);

        return $user;
    }
}
