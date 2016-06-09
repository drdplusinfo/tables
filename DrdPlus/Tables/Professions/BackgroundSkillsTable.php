<?php
namespace DrdPlus\Tables\Professions;

use DrdPlus\Codes\ProfessionCodes;
use DrdPlus\Codes\SkillCodes;
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
        if (!isset($this->originalColumnsHeader)) {
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

    private function getProfessionsRegexpPattern()
    {
        return implode(
            '|',
            array_map(
                function ($professionName) {
                    return preg_quote($professionName);
                },
                ProfessionCodes::getProfessionCodes()
            )
        );
    }

    /**
     * @return array
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        $professionsWithSkillTypes = [];
        foreach (ProfessionCodes::getProfessionCodes() as $professionCode) {
            foreach (SkillCodes::getSkillTypes() as $skillType) {
                $professionsWithSkillTypes["$professionCode $skillType"] = self::INTEGER;
            }
        }

        return $professionsWithSkillTypes;
    }

    /**
     * @return array
     */
    protected function getExpectedRowsHeader()
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
     */
    public function getFighterPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCodes::FIGHTER);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionCode
     * @return int
     */
    public function getPhysicalSkillPoints($backgroundPoints, $professionCode)
    {
        return $this->getSkillPoints($backgroundPoints, $professionCode, SkillCodes::PHYSICAL);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionName
     * @param $skillType
     * @return int
     */
    public function getSkillPoints($backgroundPoints, $professionName, $skillType)
    {
        return $this->getValue([$backgroundPoints], "$professionName $skillType");
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getFighterPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCodes::FIGHTER);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionName
     * @return int
     */
    public function getPsychicalSkillPoints($backgroundPoints, $professionName)
    {
        return $this->getSkillPoints($backgroundPoints, $professionName, SkillCodes::PSYCHICAL);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getFighterCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCodes::FIGHTER);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionName
     * @return int
     */
    public function getCombinedSkillPoints($backgroundPoints, $professionName)
    {
        return $this->getSkillPoints($backgroundPoints, $professionName, SkillCodes::COMBINED);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getThiefPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCodes::THIEF);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getThiefPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCodes::THIEF);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getThiefCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCodes::THIEF);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getRangerPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCodes::RANGER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getRangerPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCodes::RANGER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getRangerCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCodes::RANGER);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getWizardPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCodes::WIZARD);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getWizardPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCodes::WIZARD);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getWizardCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCodes::WIZARD);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getTheurgistPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCodes::THEURGIST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getTheurgistPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCodes::THEURGIST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getTheurgistCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCodes::THEURGIST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getPriestPhysicalSkillPoints($backgroundPoints)
    {
        return $this->getPhysicalSkillPoints($backgroundPoints, ProfessionCodes::PRIEST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getPriestPsychicalSkillPoints($backgroundPoints)
    {
        return $this->getPsychicalSkillPoints($backgroundPoints, ProfessionCodes::PRIEST);
    }

    /**
     * @param int $backgroundPoints
     * @return int
     */
    public function getPriestCombinedSkillPoints($backgroundPoints)
    {
        return $this->getCombinedSkillPoints($backgroundPoints, ProfessionCodes::PRIEST);
    }

}
