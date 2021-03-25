<?php

namespace Vume\Traits;

trait RelationsTrait
{
    /**
     * Add relation to builder
     *
     * @param string $relation
     * @param array $options
     * @return self
     */
    public function withRelation(string $relation, $options = [])
    {
        return $this->addRelationToBuilder($relation, $options);
    }

    /**
     * Add multiple relations to builder
     *
     * @param mixed $relations
     * @return self
     */
    public function withRelations($relations = [])
    {
        $relations = (array) $relations;

        foreach ($relations as $key => $relation) {
            if (is_array($relation)) {
                $this->withRelation($key, $relation);
            } else {
                $this->withRelation($relation);
            }
        }

        return $this;
    }

    /**
     * Add relation clause to builder
     *
     * @param string $relation
     * @param array $options
     * @return self
     */
    protected function addRelationToBuilder(string $relation, array $options = [])
    {
        if (!isset($this->builder['withRelations'])) $this->builder['withRelations'] = [];

        $this->builder['withRelations'][$relation] = $options ?: '';

        return $this;
    }
}
