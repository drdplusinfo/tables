<?php
namespace DrdPlus\Tables\Professions;

use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Codes\Skills\SkillTypeCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

/** see PPH page 39, bottom */
class BackgroundSkillsTable extends AbstractFileTable
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

    private function getRebuiltOriginalColumnsHeader(array $simplifiedColumnsHeader)
    {
        $originalColumnsHeader = [];
        $professionsPattern = $this->getProfessionsRegexpPattern();
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
     * @param string $delimiter
     * @return string
     */
    private function getProfessionsRegexpPattern($delimiter = '~')
    {
        return implode(
            '|',
            array_map(
                function ($professionName) use ($delimiter) {
                    return preg_quote($professionName, $delimiter);
                },
                ProfessionCode::getPossibleValues()
            )
        );
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
     * @return array
     */
    protected function getRowsHeader()
    {
        return ['points'];
    }

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/background_skills.csv';
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getFighterPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::FIGHTER);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionCode
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPhysicalSkillPoints($backgroundPoints, $professionCode)
    {
        return $this->getSkillPoints($backgroundPoints, $professionCode, SkillTypeCode::PHYSICAL);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionName
     * @param $skillType
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getSkillPoints($backgroundPoints, $professionName, $skillType)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue([$backgroundPoints], "$professionName $skillType");
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getFighterPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::FIGHTER);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionName
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPsychicalSkillPoints($backgroundPoints, $professionName)
    {
        return $this->getSkillPoints($backgroundPoints, $professionName, SkillTypeCode::PSYCHICAL);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getFighterCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::FIGHTER);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionName
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCombinedSkillPoints($backgroundPoints, $professionName)
    {
        return $this->getSkillPoints($backgroundPoints, $professionName, SkillTypeCode::COMBINED);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getThiefPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::THIEF);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getThiefPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::THIEF);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getThiefCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::THIEF);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getRangerPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::RANGER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getRangerPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::RANGER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getRangerCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::RANGER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getWizardPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::WIZARD);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getWizardPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::WIZARD);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getWizardCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::WIZARD);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getTheurgistPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::THEURGIST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getTheurgistPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::THEURGIST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getTheurgistCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::THEURGIST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPriestPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::PRIEST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPriestPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::PRIEST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getPriestCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::PRIEST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCommonerPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCode::COMMONER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCommonerPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCode::COMMONER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getCommonerCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCode::COMMONER);
    }

}