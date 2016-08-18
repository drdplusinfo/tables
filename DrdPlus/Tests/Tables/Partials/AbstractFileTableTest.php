<?php
namespace DrdPlus\Tests\Tables\Measurements\Partials;

use DrdPlus\Tables\Partials\AbstractFileTable;

class AbstractFileTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\CanNotReadFile
     */
    public function I_am_stopped_if_datafile_has_not_been_read()
    {
        $table = new TableWithWrongFileReference();
        @$table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\NoDataFetched
     */
    public function I_am_stopped_if_datafile_is_empty()
    {
        $table = new TableWithEmptyFilename();
        $table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\DataAreCorrupted
     */
    public function I_am_stopped_if_header_row_is_missing()
    {
        $table = new TableWithMissingHeaderRow();
        $table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\DataAreCorrupted
     */
    public function I_am_stopped_if_header_column_is_missing()
    {
        $table = new TableWithMissingHeaderColumn();
        $table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\DataAreCorrupted
     */
    public function I_am_stopped_if_header_value_is_invalid()
    {
        $table = new TableWithUnexpectedDataHeaderValue();
        $table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\UnknownScalarTypeForColumn
     */
    public function I_can_not_use_table_with_unknown_column_type()
    {
        $table = new TableWithUnknownColumnScalarType();
        $table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\NoRowRequested
     */
    public function I_can_not_request_row_without_providing_indexes()
    {
        $table = new TableWithPublicHeaders();
        $table->getRow([]);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function I_can_not_get_row_by_invalid_index()
    {
        $table = new TableWithPublicHeaders();
        $table->getRow(['non-existing index']);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     */
    public function I_can_not_get_value_by_invalid_indexes()
    {
        $table = new TableWithPublicHeaders();
        $table->getValue(['baz'], 'non-existing column index');
    }

    /**
     * @test
     */
    public function I_can_use_table_without_rows_header()
    {
        $table = new TableWithEmptyRowsHeader();
        self::assertSame([], $table->getHeader());
        self::assertSame([['foo' => 'baz', 'bar' => 'qux']], $table->getIndexedValues());
    }
}

/** inner */
class TableWithWrongFileReference extends AbstractFileTable
{

    protected function getDataFileName()
    {
        return 'non existing filename';
    }

    protected function getRowsHeader()
    {
        return [];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [];
    }

    public function getHeader()
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

    protected function getRowsHeader()
    {
        return [999 => ['foo']];
    }

    protected function getExpectedDataHeaderNamesToTypes()
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

    protected function getRowsHeader()
    {
        return [999 => 'foo'];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [];
    }
}

class TableWithUnexpectedDataHeaderValue extends TableWithEmptyFilename
{

    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, 'invalid header');

        return $this->dataFileName;
    }

    protected function getRowsHeader()
    {
        return ['expected header'];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [];
    }
}

class TableWithPublicHeaders extends TableWithEmptyFilename
{
    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, implode(',', ['foo', 'bar']) . "\n" . implode(',', ['baz', 123]));

        return $this->dataFileName;
    }

    public function getRowsHeader()
    {
        return ['foo'];
    }

    public function getExpectedDataHeaderNamesToTypes()
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

    protected function getRowsHeader()
    {
        return ['foo'];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return ['bar' => 'unknown type'];
    }
}

class TableWithEmptyRowsHeader extends TableWithEmptyFilename
{
    protected function getDataFileName()
    {
        file_put_contents($this->dataFileName, implode(',', ['foo', 'bar']) . "\n" . implode(',', ['baz', 'qux']));

        return $this->dataFileName;
    }

    protected function getRowsHeader()
    {
        return [];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return ['foo' => self::STRING, 'bar' => self::STRING];
    }
}
