<?php
namespace System\Net\WebSockets;

class WebSocketError
{
    const ConnectionClosedPrematurely = 1;
    const Faulted = 1;
    const HeaderError = 1;
    const InvalidMessageType = 1;
    const InvalidState = 1;
    const NativeError = 1;
    const NotAWebSocket = 1;
    const Success = 1;
    const UnsupportedProtocol = 1;
    const UnsupportedVersion = 1;
}