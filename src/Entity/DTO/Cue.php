<?php declare(strict_types=1);

namespace App\Entity\DTO;

class Cue
{
    private string $direction;

    private string $style;

    private string $text;

    private ?string $iconUrl;

    private int $offset;

    /**
     * @param string $direction
     * @param string $style
     * @param string $text
     * @param string|null $iconUrl
     * @param int $offset
     * @return Cue
     */
    public static function create(string $direction, string $style, string $text, int $offset, ?string $iconUrl = null): Cue
    {
        $cue = new self();
        $cue->direction = $direction;
        $cue->style = $style;
        $cue->text = $text;
        $cue->offset = $offset;

        if (!\is_null($iconUrl)) {
            $cue->iconUrl = $iconUrl;
        }

        return $cue;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * @param string $style
     */
    public function setStyle(string $style): void
    {
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string|null
     */
    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    /**
     * @param string|null $iconUrl
     */
    public function setIconUrl(?string $iconUrl): void
    {
        $this->iconUrl = $iconUrl;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }
}
