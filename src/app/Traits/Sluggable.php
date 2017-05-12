<?php
namespace Afrittella\BackProject\Traits;

trait Sluggable
{
    /**
     * Create a unique slug
     * @param $value
     * @param $id
     * @return string
     */
    public function createSlug($value, $id = 0)
    {
        $slug = str_slug($value);

        $relatedSlugs = $this->getRelatedSlugs($slug, $id);

        if (!$relatedSlugs->contains('slug', $slug)) {
            return $slug;
        }

        $completed = false;
        $i = 1;

        while ($completed == false) {
            $newSlug = $slug .'-'.$i;
            if (!$relatedSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
            $i++;
        }

        return $slug;
    }

    /**
     * Get similar slugs
     * @param $slug
     * @param $id
     * @return mixed
     */
    protected function getRelatedSlugs($slug, $id = 0)
    {
        return $this->select('slug')->where('slug', 'like', $slug.'%')->where('id', '<>', $id)->get();
    }
}