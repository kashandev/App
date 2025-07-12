import React, { useState, useRef, useEffect } from "react";
import { MdVolumeUp, MdKeyboardVoice, MdClear } from "react-icons/md";

const App = () => {
  const [text, setText] = useState("");
  const [spokenText, setSpokenText] = useState("");
  const [searchResults, setSearchResults] = useState([]);
  const [loading, setLoading] = useState(false);
  const [speechSupported, setSpeechSupported] = useState(true);
  const recognitionRef = useRef(null);
  const [voices, setVoices] = useState([]);

  useEffect(() => {
    // Load speech synthesis voices
    if ("speechSynthesis" in window) {
      const loadVoices = () => {
        const allVoices = window.speechSynthesis.getVoices();
        setVoices(allVoices);
      };
      loadVoices();
      window.speechSynthesis.onvoiceschanged = loadVoices;
    }

    // Check speech recognition support
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
      setSpeechSupported(false);
    }
  }, []);

  const handleSpeak = () => {
    if (!text.trim()) {
      alert("Please enter some text to speak.");
      return;
    }

    // Stop any ongoing recognition
    if (recognitionRef.current) recognitionRef.current.abort();
    window.speechSynthesis.cancel();

    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = "en-US";
    utterance.voice = voices.find((v) => v.lang === "en-US") || voices[0];
    window.speechSynthesis.speak(utterance);

    setSpokenText(""); // Clear previously spoken text
  };

  const handleListen = async () => {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
      alert("❌ Speech Recognition not supported on this browser.");
      return;
    }

    try {
      // Ask for mic permission
      await navigator.mediaDevices.getUserMedia({ audio: true });

      // Cancel previous speech or recognition
      window.speechSynthesis.cancel();
      if (recognitionRef.current) recognitionRef.current.abort();

      const recognition = new SpeechRecognition();
      recognition.continuous = false;
      recognition.lang = "en-US";
      recognition.interimResults = false;

      recognition.onstart = () => {
        setSpokenText("🎤 Listening...");
      };

      recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        setSpokenText(transcript);
        setText(""); // Clear manual input
        handleSearch(transcript);
      };

      recognition.onerror = (event) => {
        console.error("Speech recognition error:", event.error);
        let errorMessage = "Speech recognition failed.";
        if (event.error === "not-allowed") {
          errorMessage = "Microphone access denied. Please allow it.";
        } else if (event.error === "no-speech") {
          errorMessage = "No speech detected. Try again.";
        }
        setSpokenText(errorMessage);
      };

      recognition.onend = () => {
        recognitionRef.current = null;
      };

      recognitionRef.current = recognition;
      setTimeout(() => recognition.start(), 200); // Small delay improves Android support
    } catch (err) {
      console.error("Microphone access error:", err);
      alert("Please allow microphone access to use voice input.");
    }
  };

  const handleSearch = async (query) => {
    if (!query.trim()) return;
    setLoading(true);
    setSearchResults([]);

    try {
      const response = await fetch(
        `https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=${encodeURIComponent(
          query
        )}&format=json&origin=*`
      );
      const data = await response.json();

      const results =
        data?.query?.search?.map((item) => {
          const pageUrl = `https://en.wikipedia.org/wiki/${encodeURIComponent(item.title)}`;
          const cleanSnippet = item.snippet.replace(/<\/?[^>]+(>|$)/g, "");
          return {
            title: item.title,
            snippet: cleanSnippet,
            url: pageUrl,
          };
        }) || [];

      if (results.length === 0) {
        setSearchResults([{ title: "No results found.", snippet: "", url: "#" }]);
      } else {
        setSearchResults(results.slice(0, 5));
      }

      if ("speechSynthesis" in window && results.length > 0) {
        const summary = results[0].title + ". " + results[0].snippet;
        const utterance = new SpeechSynthesisUtterance(`Top result: ${summary}`);
        utterance.voice = voices.find((v) => v.lang === "en-US") || voices[0];
        window.speechSynthesis.speak(utterance);
      }
    } catch (error) {
      console.error("Wikipedia search failed:", error);
      setSearchResults([{ title: "Search error occurred.", snippet: "", url: "#" }]);
    } finally {
      setLoading(false);
    }
  };

  const handleClear = () => {
    window.speechSynthesis.cancel();
    if (recognitionRef.current) recognitionRef.current.abort();
    setText("");
    setSpokenText("");
    setSearchResults([]);
  };

  const iconButtonStyle = {
    width: 50,
    height: 50,
    borderRadius: "50%",
    fontSize: 26,
    display: "flex",
    alignItems: "center",
    justifyContent: "center",
    border: "none",
    cursor: "pointer",
    transition: "0.3s",
    flexShrink: 0,
  };

  return (
    <div style={{ padding: 20, fontFamily: "Arial", maxWidth: 800, margin: "auto" }}>
      <h2 style={{ fontSize: 24, marginBottom: 20, textAlign: "center" }}>🎙️ Voice Assistant</h2>

      {!speechSupported && (
        <div
          style={{
            padding: 10,
            backgroundColor: "#ffe0e0",
            borderRadius: 6,
            color: "#a00",
            marginBottom: 20,
          }}
        >
          ⚠️ Speech recognition is not supported on this device or browser.
        </div>
      )}

      <div style={{ marginBottom: 30 }}>
        <textarea
          rows="4"
          placeholder="Type text to speak..."
          value={text}
          onChange={(e) => setText(e.target.value)}
          style={{
            width: "100%",
            fontSize: 16,
            padding: 10,
            borderRadius: 8,
            border: "1px solid #ccc",
            resize: "vertical",
            minHeight: 100,
          }}
        />

        <div
          style={{
            marginTop: 10,
            display: "flex",
            flexWrap: "wrap",
            gap: 10,
            justifyContent: "center",
          }}
        >
          <button
            onClick={handleSpeak}
            aria-label="Speak text"
            style={{ ...iconButtonStyle, backgroundColor: "#007bff", color: "#fff" }}
            title="Speak Text"
          >
            <MdVolumeUp />
          </button>

          <button
            onClick={handleListen}
            aria-label="Start voice recognition"
            style={{ ...iconButtonStyle, backgroundColor: "#28a745", color: "#fff" }}
            title="Voice Recognition"
            disabled={!speechSupported}
          >
            <MdKeyboardVoice />
          </button>

          <button
            onClick={handleClear}
            aria-label="Clear"
            style={{ ...iconButtonStyle, backgroundColor: "#dc3545", color: "#fff" }}
            title="Clear"
          >
            <MdClear />
          </button>
        </div>
      </div>

      <hr />

      <div style={{ marginTop: 30 }}>
        {spokenText && (
          <p style={{ fontSize: 16, wordWrap: "break-word" }}>
            <strong>Recognized:</strong> {spokenText}
          </p>
        )}
        {loading && <p style={{ marginTop: 10 }}>🔄 Searching Wikipedia...</p>}
      </div>

      {searchResults.length > 0 && (
        <div style={{ marginTop: 30 }}>
          <h3 style={{ fontSize: 18 }}>🔎 Search Results:</h3>
          <ul style={{ marginTop: 10, lineHeight: 1.6, paddingLeft: 20 }}>
            {searchResults.map((result, index) => (
              <li key={index} style={{ marginBottom: 12 }}>
                <a href={result.url} target="_blank" rel="noopener noreferrer" style={{ fontWeight: "bold" }}>
                  {result.title}
                </a>
                <div style={{ fontSize: 14, marginTop: 4 }}>{result.snippet}</div>
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  );
};

export default App;
