<?php

namespace App\Repositories\Videos;
use App\Models\Video;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Videos\VideoRepositoryInterface;

class VideoEloquentRepository extends EloquentRepository implements VideoRepositoryInterface
{
    /**
     * Implement abstract method and base model
     *
     * @return mixed | model
     */
    public function getModel()
    {
        return Video::class;
    }

    public function getVideo($videoId){
        return $this->_model->with('author', 'likes')->where('id', $videoId)->first();
    }
}