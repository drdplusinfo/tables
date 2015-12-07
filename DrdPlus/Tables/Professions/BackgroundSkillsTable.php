<?php
namespace DrdPlus\Tables\Professions;

use DrdPlus\Codes\ProfessionCodes;
use DrdPlus\Codes\SkillCodes;

class BackgroundSkillsTable extends AbstractTable
{

    /**
     * @return array
     */
    protected function getExpectedColumnsHeader()
    {
        /** see PPH page 39, bottom */
        return [
            [ // axis X first row header
                ProfessionCodes::FIGHTER, ProfessionCodes::FIGHTER, ProfessionCodes::FIGHTER,
                ProfessionCodes::THIEF, ProfessionCodes::THIEF, ProfessionCodes::THIEF,
                ProfessionCodes::RANGER, ProfessionCodes::RANGER, ProfessionCodes::RANGER,
                ProfessionCodes::WIZARD, ProfessionCodes::WIZARD, ProfessionCodes::WIZARD,
                ProfessionCodes::THEURGIST, ProfessionCodes::THEURGIST, ProfessionCodes::THEURGIST,
                ProfessionCodes::PRIEST, ProfessionCodes::PRIEST, ProfessionCodes::PRIEST
            ],
            [ // axis X second row header
                SkillCodes::PHYSICAL, SkillCodes::PSYCHICAL, SkillCodes::COMBINED, // fighter
                SkillCodes::PHYSICAL, SkillCodes::PSYCHICAL, SkillCodes::COMBINED, // thief
                SkillCodes::PHYSICAL, SkillCodes::PSYCHICAL, SkillCodes::COMBINED, // ranger
                SkillCodes::PHYSICAL, SkillCodes::PSYCHICAL, SkillCodes::COMBINED, // wizard
                SkillCodes::PHYSICAL, SkillCodes::PSYCHICAL, SkillCodes::COMBINED, // theurgist
                SkillCodes::PHYSICAL, SkillCodes::PSYCHICAL, SkillCodes::COMBINED, // priest
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getExpectedRowsHeader()
    {
        return [
            ['points', '']
        ];
    }

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/background_skills_table.csv';
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
     * @param $professionName
     * @return int
     */
    private function getPhysicalSkillPoints($backgroundPoints, $professionName)
    {
        return $this->getSkillPoints($backgroundPoints, $professionName, SkillCodes::PHYSICAL);
    }

    /**
     * @param int $backgroundPoints
     * @param $professionName
     * @param $skillType
     * @return int
     */
    private function getSkillPoints($backgroundPoints, $professionName, $skillType)
    {
        $skillPoints = $this->getValue([$backgroundPoints], [$professionName, $skillType]);
        if (!is_int($skillPoints)) {
            throw new \LogicException;
        }

        return $skillPoints;
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
    private function getPsychicalSkillPoints($backgroundPoints, $professionName)
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
    private function getCombinedSkillPoints($backgroundPoints, $professionName)
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
