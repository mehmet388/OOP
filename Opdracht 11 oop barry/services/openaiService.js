
import OpenAI from "openai";
const client = new OpenAI({ apiKey: process.env.OPENAI_API_KEY });

export async function analyzeCode(code) {
  const response = await client.chat.completions.create({
    model: "gpt-4.1-mini",
    messages: [
      { role: "system", content: "You are a helpful code reviewer." },
      { role: "user", content: code }
    ]
  });

  return response.choices[0].message.content;
}
