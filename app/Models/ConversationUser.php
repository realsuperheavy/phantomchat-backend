<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ConversationUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'conversations_users';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getConversationId(): int
    {
        return $this->conversation_id;
    }

    public function setConversationId(int $conversation_id): self
    {
        $this->conversation_id = $conversation_id;
        return $this;
    }

    public function getDeletedAt(): ?Carbon
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?Carbon $deleted_at): self
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }
}
