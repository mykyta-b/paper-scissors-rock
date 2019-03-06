<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace PSRG\Core\DTO;


class PlayerDTO
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $strategy;

    /**
     * @var string
     */
    protected $turn;

    /**
     * @return string
     */
    public function getTurn(): ?string
    {
        return $this->turn;

    }

    /**
     * @param string $turn
     * @return PlayerDTO
     */
    public function setTurn(string $turn): PlayerDTO
    {
        $this->turn = $turn;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return PlayerDTO
     */
    public function setType(string $type): PlayerDTO
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $name
     * @return PlayerDTO
     */
    public function setAlias($name): PlayerDTO
    {
        $this->alias = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PlayerDTO
     */
    public function setName(string $name): PlayerDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrategy(): ?string
    {
        return $this->strategy;
    }

    /**
     * @param string $strategy
     * @return PlayerDTO
     */
    public function setStrategy(string $strategy): PlayerDTO
    {
        $this->strategy = $strategy;
        return $this;
    }
}
