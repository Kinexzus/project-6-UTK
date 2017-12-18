<?php
require_once dirname(__FILE__).'/../FileSystem.php';

class FileSystemTest extends PHPUnit_Framework_TestCase
{
    //__construct
    function test_construct()
    {
        if(!file_exists(dirname(__FILE__).'/FSTest'))
            mkdir(dirname(__FILE__).'/FSTest');
        $file = fopen(dirname(__FILE__).'/rightsTestFile', 'w');

        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $params = [$fileSystem->getCloudPath(), $fileSystem->getRightsPath()];

        $this->assertEquals(['C:\dev\Cloud\project-6-UTK\Tests\FSTest', 'C:\dev\Cloud\project-6-UTK\Tests\rightsTestFile'], $params);
    }


    //cl2fs($__clpath)
    function test_cl2fs()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $clpaths = ['/Kolya/dir1/file', '\Petya\dir2\file.txt', '/'];
        $fspaths = [];
        foreach ($clpaths as $clpath)
            $fspaths[] = $fileSystem->cl2fs($clpath);

        $this->assertEquals([dirname(__FILE__).'\FSTest\Kolya\dir1\file',
            dirname(__FILE__).'\FSTest\Petya\dir2\file.txt',
            dirname(__FILE__).'\FSTest\\'],
            $fspaths);
    }

    //fs2cl($__fspath)
    function test_fs2cl()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $fspaths = [dirname(__FILE__).'\FSTest\Kolya\dir1\file',
            dirname(__FILE__).'\FSTest\Petya\dir2\file.txt',
            dirname(__FILE__).'\FSTest\\'];
        $clpaths = [];
        foreach ($fspaths as $fspath)
            $clpaths[] = $fileSystem->fs2cl($fspath);

        $this->assertEquals(['\Kolya\dir1\file',
            '\Petya\dir2\file.txt',
            '\\'],
            $clpaths);
    }


    //setRights($__clpath, $__owner, $__users)
    function test_setRights()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $files = [];
        $files[] = ['\Vano\folder\folder', 'Vano', []];
        $files[] = ['\Igor\sound.mp3', 'Igor', NULL];
        $files[] = ['\Kolya\dir1\file', 'Kolya', ['Igor', 'Alex', 'Vano']];

        foreach ($files as $file)
            $fileSystem->setRights($file[0], $file[1], $file[2]);

        $filesRights = '';
        $filesRights .= $files[0][0]."::".$files[0][1]."::\n";
        $filesRights .= $files[1][0]."::".$files[1][1]."::@\n";
        $filesRights .= $files[2][0]."::".$files[2][1]."::Igor,Alex,Vano\n";

        $this->assertStringEqualsFile(dirname(__FILE__).'/rightsTestFile', $filesRights);
    }


    //getRight($__clpath, $__user)
    function test_getRight()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $rights = [];

        $rights[] = $fileSystem->getRight('\Vano\folder\folder', 'Vano');
        $rights[] = $fileSystem->getRight('\Vano\folder\folder', 'Kolya');
        $rights[] = $fileSystem->getRight('\Vano\folder\folder', 'Igor');

        $rights[] = $fileSystem->getRight('\Igor\sound.mp3', 'Igor');
        $rights[] = $fileSystem->getRight('\Igor\sound.mp3', 'Vano');
        $rights[] = $fileSystem->getRight('\Igor\sound.mp3', 'Dima');

        $rights[] = $fileSystem->getRight('\Kolya\dir1\file', 'Kolya');
        $rights[] = $fileSystem->getRight('\Kolya\dir1\file', 'Igor');
        $rights[] = $fileSystem->getRight('\Kolya\dir1\file', 'Alex');
        $rights[] = $fileSystem->getRight('\Kolya\dir1\file', 'Vano');
        $rights[] = $fileSystem->getRight('\Kolya\dir1\file', 'Dima');

        $expected = ['rw', '--', '--',
                    'rw', 'r-', 'r-',
                    'rw', 'r-', 'r-', 'r-', '--'];

        $this->assertEquals($expected, $rights);
    }

    //getRights($__clpath)
    function test_getRights()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $rights = [];

        $rights[] = $fileSystem->getRights('\Vano\folder\folder');
        $rights[] = $fileSystem->getRights('\Igor\sound.mp3');
        $rights[] = $fileSystem->getRights('\Kolya\dir1\file');

        $file1 = [];
        $file1['owner'] = 'Vano';
        $file1['readers'] = [];
        $file2 = [];
        $file2['owner'] = 'Igor';
        $file2['readers'] = NULL;
        $file3 = [];
        $file3['owner'] = 'Kolya';
        $file3['readers'] = ['Igor', 'Alex', 'Vano'];
        $expected = [$file1, $file2, $file3];

        $this->assertEquals($expected, $rights);
    }


    //changeRights($__clpath, $__users)
    function test_changeRights()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $files = [];
        $files[] = ['\Vano\folder\folder', ['Vova']];
        $files[] = ['\Igor\sound.mp3', []];
        $files[] = ['\Kolya\dir1\file', NULL];

        $fileSystem->changeRights($files[1][0], $files[1][1]);
        $fileSystem->changeRights($files[2][0], $files[2][1]);
        $fileSystem->changeRights($files[0][0], $files[0][1]);

        $filesRights = '';
        $filesRights .= $files[0][0]."::Vano::Vova\n";
        $filesRights .= $files[1][0]."::Igor::\n";
        $filesRights .= $files[2][0]."::Kolya::@\n";

        $this->assertStringEqualsFile(dirname(__FILE__).'/rightsTestFile', $filesRights);
    }


    //delFileRights($__clpath)
    function test_delFileRights()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $fileSystem->delFileRights('\Igor\sound.mp3');

        $files = [];
        $files[] = ['\Vano\folder\folder', ['Vova']];
        $files[] = ['\Igor\sound.mp3', []];
        $files[] = ['\Kolya\dir1\file', NULL];

        $filesRights = '';
        $filesRights .= $files[0][0]."::Vano::Vova\n";
        $filesRights .= $files[2][0]."::Kolya::@\n";

        $this->assertStringEqualsFile(dirname(__FILE__).'/rightsTestFile', $filesRights);
    }


    //fileExists($__clpath)
    function test_fileExists()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $flag = $fileSystem->fileExists('\000');
        $flag *= $fileSystem->fileExists('\111');
        $flag *= !$fileSystem->fileExists('\222');

        $this->assertEquals(true, $flag);
    }


    //addFile($__clpath, $__file_name)
    function test_addFile()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $fileSystem->addFile('\\', 'dir1');
        $fileSystem->addFile('\\', 'dir1');
        $fileSystem->addFile('\\', 'dir1');
        $fileSystem->addFile('\\', 'dir2');
        $fileSystem->addFile('\dir2', 'dir3');

        $flag = $fileSystem->fileExists('\dir1');
        $flag *= $fileSystem->fileExists('\dir1(1)');
        $flag *= $fileSystem->fileExists('\dir1(2)');
        $flag *= $fileSystem->fileExists('\dir2');
        $flag *= $fileSystem->fileExists('\dir2\dir3');

        $this->assertEquals(true, $flag);
    }


    //removeFile($__clpath)
    function test_removeFile()
    {
        $fileSystem = new FileSystem(dirname(__FILE__)."/FSTest", dirname(__FILE__)."/rightsTestFile");

        $fileSystem->removeFile('\dir1');
        $fileSystem->removeFile('\dir1(1)');
        $fileSystem->removeFile('\dir1(2)');
        $fileSystem->removeFile('\dir2');
        $fileSystem->removeFile('\dir2\dir3');

        $flag = $fileSystem->fileExists('\dir1');
        $flag += $fileSystem->fileExists('\dir1(1)');
        $flag += $fileSystem->fileExists('\dir1(2)');
        $flag += $fileSystem->fileExists('\dir2');
        $flag += $fileSystem->fileExists('\dir2\dir3');

        $this->assertEquals(false, $flag);
    }

}
