<?php
namespace App\Repositories\Comments;
use App\Models\Comment;
use App\Repositories\Eloquent\EloquentRepository;



class CommentEloquentRepository extends EloquentRepository implements CommentRepositoryInterface
{
    /**
     * Get the model class name.
     *
     * @return string
     */
    public function getModel(): string
    {
        return Comment::class;
    }

    /**
     * Define specialized methods for comments.
     */
    // Add methods specific to comments here, e.g., getCommentsByVideoId, etc.
}