<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';

    protected $casts = [
        'started' => 'boolean',
        'referent_time' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    public function conversationUsers(): HasMany
    {
        return $this->hasMany(ConversationUser::class, 'conversation_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversations_users', 'conversation_id', 'user_id');
    }

    public function displayUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversations_users', 'conversation_id', 'user_id')
            ->wherePivot('user_id', '!=', Auth::id());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getConversationIdentifier(): string
    {
        return $this->conversation_identifier;
    }

    public function setConversationIdentifier(string $conversation_identifier): self
    {
        $this->conversation_identifier = $conversation_identifier;
        return $this;
    }
}
