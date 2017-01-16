<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Codes\Skills\SkillTypeCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\PositiveInteger;
use Granam\String\StringInterface;

/** see PPH page 39, bottom, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_dovednosti */
class SkillsByBackgroundPointsTable extends AbstractFileTable
{
    /**
     * @var array
     */
    private $originalColumnsHeader;

    /**
     * @return array|string[][][]
     */
    protected function getColumnsHeader()
    {
        if ($this->originalColumnsHeader === null) {
            $simplifiedColumnsHeader = parent::getColumnsHeader();
            $this->originalColumnsHeader = $this->getRebuiltOriginalColumnsHeader($simplifiedColumnsHeader);
        }

        return $this->originalColumnsHeader;
    }

    /**
     * @param array $simplifiedColumnsHeader
     * @return array
     */
    private function getRebuiltOriginalColumnsHeader(array $simplifiedColumnsHeader)
    {
        $originalColumnsHeader = [];
        $professionsPattern = implode(
            '|',
            array_map(
                function ($professionName) {
                    return preg_quote($professionName, '~');
                },
                ProfessionCode::getPossibleValues()
            )
        );
        foreach ($simplifiedColumnsHeader as $simplifiedColumnName) {
            $originalColumnHeader = ['', ''];
            preg_match('~(?<profession>' . $professionsPattern . ')\s+(?<skillType>\w+)~', $simplifiedColumnName, $matches);
            $originalColumnHeader[0] = $matches['profession'];
            $originalColumnHeader[1] = $matches['skillType'];
            $originalColumnsHeader[] = $originalColumnHeader;
        }

        return $originalColumnsHeader;
    }

    /**
     * @return array
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        $professionsWithSkillTypes = [];
        foreach (ProfessionCode::getPossibleValues() as $professionCode) {
            foreach (SkillTypeCode::getPossibleValues() as $skillTypeCode) {
                $professionsWithSkillTypes["$professionCode $skillTypeCode"] = self::INTEGER;
            }
        }

        return $professionsWithSkillTypes;
    }

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [BackgroundPointsTable::BACKGROUND_POINTS];
    }

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/skills_by_background_points.csv';
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getFighterPhysicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::FIGHTER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @param ProfessionCode $professionCode
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPhysicalSkillPoints(PositiveInteger $backgroundPoints, ProfessionCode $professionCode)
    {
        return $this->getSkillPoints($backgroundPoints, $professionCode, SkillTypeCode::PHYSICAL);
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @param ProfessionCode $professionCode
     * @param string|StringInterface $skillType
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getSkillPoints(PositiveInteger $backgroundPoints, ProfessionCode $professionCode, $skillType)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($backgroundPoints, "$professionCode $skillType");
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getFighterPsychicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::FIGHTER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @param ProfessionCode $professionCode
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPsychicalSkillPoints(PositiveInteger $backgroundPoints, ProfessionCode $professionCode)
    {
        return $this->getSkillPoints($backgroundPoints, $professionCode, SkillTypeCode::PSYCHICAL);
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getFighterCombinedSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::FIGHTER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @param ProfessionCode $professionCode
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCombinedSkillPoints(PositiveInteger $backgroundPoints, ProfessionCode $professionCode)
    {
        return $this->getSkillPoints($backgroundPoints, $professionCode, SkillTypeCode::COMBINED);
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getThiefPhysicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::THIEF));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getThiefPsychicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::THIEF));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getThiefCombinedSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::THIEF));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getRangerPhysicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::RANGER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getRangerPsychicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::RANGER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getRangerCombinedSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::RANGER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getWizardPhysicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::WIZARD));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getWizardPsychicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::WIZARD));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getWizardCombinedSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::WIZARD));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getTheurgistPhysicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::THEURGIST));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getTheurgistPsychicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::THEURGIST));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getTheurgistCombinedSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::THEURGIST));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPriestPhysicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::PRIEST));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPriestPsychicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::PRIEST));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPriestCombinedSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::PRIEST));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCommonerPhysicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::COMMONER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCommonerPsychicalSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::COMMONER));
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCommonerCombinedSkillPoints(PositiveInteger $backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::getIt(ProfessionCode::COMMONER));
    }

}