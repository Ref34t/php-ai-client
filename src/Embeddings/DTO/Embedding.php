<?php

declare(strict_types=1);

namespace WordPress\AiClient\Embeddings\DTO;

/**
 * Represents an embedding vector
 *
 * Embeddings are numerical representations of text that capture semantic meaning,
 * used for tasks like similarity search and clustering.
 *
 * @since n.e.x.t
 */
class Embedding
{
    /**
     * @var float[] The embedding vector
     */
    private array $vector;

    /**
     * Constructor
     *
     * @since n.e.x.t
     * @param float[] $vector The embedding vector
     */
    public function __construct(array $vector)
    {
        $this->vector = $vector;
    }

    /**
     * Get the embedding vector
     *
     * @since n.e.x.t
     * @return float[] The vector
     */
    public function getVector(): array
    {
        return $this->vector;
    }

    /**
     * Get the dimension of the embedding
     *
     * @since n.e.x.t
     * @return int The number of dimensions
     */
    public function getDimension(): int
    {
        return count($this->vector);
    }
}