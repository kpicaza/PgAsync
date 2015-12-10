<?php

namespace PgAsync\Message;

class NoticeResponse implements ParserInterface
{
    use ParserTrait;

    private $noticeMessages = [];

    /**
     * @inheritDoc
     */
    public function parseMessage($rawMessage)
    {
        $rawMsgs = substr($rawMessage, 5);
        $parts   = explode("\0", $rawMsgs);

        foreach ($parts as $part) {
            if (strlen($part) < 2) {
                break;
            }
            $fieldType = $part[0];

            $msg = substr($part, 1);

            $this->noticeMessages[] = [
                "type"    => $fieldType,
                "message" => $msg
            ];
        }
    }

    /**
     * @inheritDoc
     */
    public static function getMessageIdentifier()
    {
        return 'N';
    }

    /**
     * @return array
     */
    public function getNoticeMessages()
    {
        return $this->noticeMessages;
    }
}
