

## Start/Goto a Conversation.
Use ```Inbox::getMessageLink($friendId, $myID)```.
 E.g to start a conversation with User 7
```html
    <a  href="{{ Inbox::getMessageLink(7) }}"> Chat with User 7 </a>
```


##Send Message with Ajax
This will call ```Inbox::processSendMessage()``` method
```javascript
    function sendMessage(){
        Popup1.input('Send Message', 'Start conversation with {{ $productUserInfo->full_name }}', {'type':'textarea'}, function(message){
            let toUserId = "{{ $productUserInfo->id }}";    // receiver
            Ajax1.requestGet("{{ Form1::callApi("Inbox::processSendMessage(null, null, false)?token=".token()) }}&to_user_id=" +toUserId+ "&message="+message, null, function(result){
                if(result.status) Popup1.alert('Message Sent', '', 'success');
                else Popup1.alert('Message Failed', result.message, 'danger');
            });
        })
    }
```
