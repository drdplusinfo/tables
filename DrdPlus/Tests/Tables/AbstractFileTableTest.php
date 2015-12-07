<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\AbstractFileTable;

class AbstractFileTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\CanNotReadFile
     */
    public function I_am_stopped_if_datafile_has_not_been_read()
    {
        $table = new TableWithWrongFileReference();
        @$table->getValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\NoDataFetched
     */
    public function I_am_stopped_if_datafile_is_empty()
    {
        $table = new TableWithEmptyFilename();
        $table->getValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\DataAreCorrupted
     */
    public function I_am_stopped_if_header_row_is_missing()
    {
        $table = new TableWithMissingHeaderRow();
        $table->getValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\DataAreCorrupted
     */
    public function I_am_stopped_if_header_column_is_missing()
    {
        $table = new TableWithMissingHeaderColumn();
        $table->getValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\DataAreCorrupted
     */
    public function I_am_stopped_if_header_value_is_invalid()
    {
        $table = new TableWithUnexpectedHeaderValue();
        $table->getValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownScalarTypeForColumn
     */
    public function I_can_not_use_table_with_unknown_column_type()
    {
        $table = new TableWithUnknownColumnScalarType();
        $table->getValues();
    }
}

/** inner */
class TableWithWrongFileReference extends AbstractFileTable
{

    protected function getDataFileName()
    {
        return 'non existing filename';
    }

    protected function getExpectedRowsHeader()
    {
        return [];
    }

    protected function getExpectedColumnsHeader()
    {
        return [];
    }

}

class TableWithEmptyFilename extends TableWithWrongFileReference
{
    protected $dataFileName;

    public function __construct()
    {
        $this->dataFileName = $this->createDataFileName();
    }

    protected function createDataFileName()
    {
        return tempnam(sys_get_temp_dir(), preg_replace('~^.*[\\\](\w+)$~', '$1', __CLASS__));
    }

    public function __destruct()
    {
        if (file_exists($this->dataFileName)) {
            unlink($this->dataFileName);
        }
    }

    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, '');

        return $this->dataFileName;
    }
}

class TableWithMissingHeaderRow extends TableWithEmptyFilename
{

    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, 'foo');

        return $this->dataFileName;
    }

    protected function getExpectedRowsHeader()
    {
        return [999 => ['foo']];
    }

    protected function getExpectedColumnsHeader()
    {
        return [];
    }
}

class TableWithMissingHeaderColumn extends TableWithEmptyFilename
{

    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, 'foo');

        return $this->dataFileName;
    }

    protected function getExpectedRowsHeader()
    {
        return [999 => 'foo'];
    }

    protected function getExpectedColumnsHeader()
    {
        return [];
    }
}

class TableWithUnexpectedHeaderValue extends TableWithEmptyFilename
{

    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, 'invalid header');

        return $this->dataFileName;
    }

    protected function getExpectedRowsHeader()
    {
        return ['expected header'];
    }

    protected function getExpectedColumnsHeader()
    {
        return [];
    }
}

class TableWithPublicHeaders extends TableWithEmptyFilename
{
    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, implode(',', ['foo', 'bar']) . "\n" . implode(',', ['baz', 'qux']));

        return $this->dataFileName;
    }

    protected function getExpectedRowsHeader()
    {
        return ['foo'];
    }

    protected function getExpectedColumnsHeader()
    {
        return ['bar' => self::INTEGER];
    }
}

class TableWithUnknownColumnScalarType extends TableWithEmptyFilename
{
    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, implode(',', ['foo', 'bar']) . "\n" . implode(',', ['baz', 'qux']));

        return $this->dataFileName;
    }

    protected function getExpectedRowsHeader()
    {
        return ['foo'];
    }

    protected function getExpectedColumnsHeader()
    {
        return ['bar' => 'unknown type'];
    }
}
