<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Message
{
    use HasFactory;

    public const TYPE_TEXT = 'text';
    public const TYPE_IMAGE = 'image';
    public const TYPE_VIDEO = 'video';
    public const TYPE_GIF = 'gif';

    private string $id;
    private ?string $file_path;
    private string $conversation_id;
    private int $sender_id;
    private ?string $body;
    private string $type;
    private Carbon $sent_at_local_time;
    private Carbon $created_at;
    private ?User $sender = null;

    public function getFileAbsolutePath(): ?string
    {
        return Storage::path($this->getFilePath());
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(?string $file_path): self
    {
        $this->file_path = $file_path;
        return $this;
    }

    public function getFileUrl(): ?string
    {
        if (null === $this->getFilePath()) {
            return null;
        }

        if (filter_var($this->getFilePath(), FILTER_VALIDATE_URL)) {
            return $this->getFilePath();
        }

        return Storage::url($this->getFilePath());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
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

    public function getSenderId(): int
    {
        return $this->sender_id;
    }

    public function setSenderId(int $senderId): self
    {
        $this->sender_id = $senderId;
        return $this;
    }

    public function getSender(): User
    {
        if (null === $this->sender) {
            $this->sender = User::find($this->getSenderId());
        }

        return $this->sender;
    }

    public function getBodyFormatted(): string
    {
        if (null === $this->getBody()) {
            $username = $this->getSender()->getUsername();
            switch ($this->getType()) {
                case Message::TYPE_IMAGE;
                    return __('v1/message.send.user_send_image', ['username' => $username]);
                case Message::TYPE_VIDEO;
                    return __('v1/message.send.user_send_video', ['username' => $username]);
                case Message::TYPE_GIF;
                    return __('v1/message.send.user_send_gif', ['username' => $username]);
            }
        }

        if (strlen($this->getBody()) > 140) {
            $body = substr($this->getBody(), 0, 140);
            return trim($body) . '...';
        }

        return $this->getBody();
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getSentAtLocalTime(): Carbon
    {
        return $this->sent_at_local_time;
    }

    public function setSentAtLocalTime(Carbon $sent_at_local_time): self
    {
        $this->sent_at_local_time = $sent_at_local_time;
        return $this;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function setCreatedAt(Carbon $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }
}
