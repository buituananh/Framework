<?php
namespace System\Net\WebSockets;

class WebSocketCloseStatus
{
    const Emptys = 1;
    const EndpointUnavailable = 1;
    const InternalServerError = 1;
    const InvalidMessageType = 1;
    const InvalidPayloadData = 1;
    const MandatoryExtension = 1;
    const MessageTooBig = 1;
    const NormalClosure = 1;
    const PolicyViolation = 1;
    const ProtocolError = 1;
}
