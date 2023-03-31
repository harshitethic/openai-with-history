<h2>OPENAI WITH HISTORY</h2>
<p>Hi, I am Harshit Sharma, a developer and creator of this chatbot application. You can find me on Twitter at <a href="https://twitter.com/harshitethic">@harshitethic</a>, and check out my personal website at <a href="https://harshitethic.in">harshitethic.in</a>.</p>

<p>This chatbot application consists of two main files: <code>index.html</code> and <code>callAPI.php</code>.</p>

<p><code>index.html</code> is the main frontend page where users can interact with the chatbot. It includes a simple chat interface with a message input field and a "Send" button. When the user sends a message, the input is processed using JavaScript, and the message is appended to the chat area. To handle communication with the backend, an AJAX request is made to the <code>callAPI.php</code> file, which takes care of sending the user's message to the OpenAI API and receiving the AI's response.</p>

<p><code>callAPI.php</code> is the backend file that processes user messages and interacts with the OpenAI API. It starts by initializing a session and checking if the user has requested to forget the previous interactions. It then sets up the API key, the number of interactions to remember, and retrieves the user's message from the query string. If the message contains specific keywords related to date or time, the current date and time are added to the message before sending it to the API.</p>

<p>The script then prepares the data to be sent to the OpenAI API by creating an array of messages containing the user's message and the conversation history stored in the session. The array is then sent to the OpenAI API using a cURL request.</p>

<p>Once the response is received from the OpenAI API, it is decoded, and the AI-generated content is extracted. The conversation history is then updated with the new user message and the AI-generated response. Finally, the AI's response is sent back to the frontend and displayed in the chat area.</p>

<p>This chatbot application leverages OpenAI's GPT-3.5-turbo model to provide short, friendly, and informative responses to user queries. The implementation ensures a smooth and engaging user experience while maintaining a short-term memory for more contextual interactions.</p>

<h3>Credits:</h3>
<ul>
  <li>Harshit Sharma</li>
  <li>Twitter: <a href="https://twitter.com/harshitethic">@harshitethic</a></li>
  <li>Website: <a href="https://harshitethic.in">harshitethic.in</a></li>
  <li>Year: 2023</li>
</ul>
