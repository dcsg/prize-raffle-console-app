<?php

/*
 * This file is part of the phplx Prize Raffle Console Application package.
 *
 * (c) 2013-2014 phplx.net
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phplx\Raffle\Tests\Provider;

use Phplx\Raffle\DataAdapter\FileSystemDataAdapter;

/**
 * @author Daniel Gomes <me@danielcsgomes.com>
 */
class FileSystemDataAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileSystemDataAdapter
     */
    private $fsDataAdapter;

    public function setUp()
    {
        $this->fsDataAdapter = new FileSystemDataAdapter();
        $this->fsDataAdapter->setBaseDir(sys_get_temp_dir());
        $this->fsDataAdapter->setWinnersDir(sys_get_temp_dir());
    }

    public function testSaveEvent()
    {
        $eventId = 'testSaveEvent';

        $jsonResponse = json_encode(
            array(
                 'event' => array(
                     'id' => $eventId,
                     'attendees' => array(
                         array(
                             'id' => 1,
                             'name' => 'Daniel Gomes',
                             'email' => 'me@danielcsgomes.com'
                         ),
                         array(
                             'id' => 1,
                             'name' => 'Daniel Gomes',
                             'email' => 'me@danielcsgomes.com',
                             'twitterHandler' => 'danielcsgomes'
                         )
                     ),
                     'prizes' => array(
                         array(
                             'sponsor' => 'phplx',
                             'prize' => 'prize',
                             'tweet_message' => 'phplx winner',
                             'winner' => array(
                                 'id' => 1
                             )
                         )
                     )
                 )
            )
        );

        $mock = $this->getMock('Phplx\Raffle\Model\Event', array(), array('test'), '', false);
        $mock->expects($this->atLeastOnce())
            ->method('toJson')
            ->will($this->returnValue($jsonResponse));
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($eventId));

        $this->fsDataAdapter->saveEvent($mock);

        return $eventId;
    }

    /**
     * @depends testSaveEvent
     */
    public function testGetExistingEvent($eventId)
    {
        $this->assertInstanceOf('Phplx\Raffle\Model\Event', $this->fsDataAdapter->getEvent('testSaveEvent'));

        return $eventId;
    }

    public function testGetNonExistingEvent()
    {
        $this->assertInstanceOf('Phplx\Raffle\Model\Event', $this->fsDataAdapter->getEvent('nonExistingEvent'));
    }

    /**
     * @depends testGetExistingEvent
     */
    public function testDeleteAnExistingEvent($eventId)
    {
        $this->assertTrue($this->fsDataAdapter->deleteEvent($eventId));
    }

    public function testHasEvent()
    {
        $tmpFile = sys_get_temp_dir() . '/event.json';
        file_put_contents($tmpFile, '');

        $this->assertTrue($this->fsDataAdapter->hasEvent('event'));
        unlink($tmpFile);
    }

    public function testNotHasEvent()
    {
        $this->assertFalse($this->fsDataAdapter->hasEvent('file_not_exists'));
    }

    public function testSaveWinner()
    {
        $mock = $this->getMock('Phplx\Raffle\Model\Prize');
        $mock->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue('winner'));

        $this->fsDataAdapter->saveWinner('testSaveWinner', $mock);

        $filename = sprintf($this->fsDataAdapter->getWinnersDir(), 'testSaveWinner');

        $this->assertFileExists($filename);
        $this->assertJson(file_get_contents($filename));

        return $filename;
    }

    /**
     * @depends testSaveWinner
     */
    public function testSaveWinnerWithExistingFile($filename)
    {
        $mock = $this->getMock('Phplx\Raffle\Model\Prize');
        $mock->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue('winner'));

        $this->fsDataAdapter->saveWinner('testSaveWinner', $mock);

        $this->assertFileExists($filename);
        $this->assertJson(file_get_contents($filename));

        return $filename;
    }

    /**
     * @depends testSaveWinnerWithExistingFile
     */
    public function testGetWinners($filename)
    {
        $this->assertInternalType('array', $this->fsDataAdapter->getWinners('testSaveWinner'));
        unlink($filename);
    }

    public function testClearWinnersWithExistingFile()
    {
        $content = 'test';

        $filename = sprintf($this->fsDataAdapter->getWinnersDir(), 'testSaveWinner');

        file_put_contents($filename, $content);

        $this->assertFileExists($filename);
        $this->fsDataAdapter->clearWinners('testSaveWinner', $content);

        $this->assertEquals('', file_get_contents($filename));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testClearWinnersWithoutFile()
    {
        $filename = sprintf($this->fsDataAdapter->getWinnersDir(), 'testNoFile');

        $this->assertFileNotExists($filename);
        $this->fsDataAdapter->clearWinners('testNoFile');
    }
}
