
import express from "express";
import multer from "multer";
import fs from "fs";
import path from "path";
import { analyzeCode } from "./services/openaiService.js";

const app = express();
app.set("view engine", "ejs");
app.use(express.static("public"));
app.use(express.urlencoded({ extended: true }));

const upload = multer({ dest: "uploads/" });

app.get("/", (req, res) => res.render("index"));

app.post("/analyze", upload.single("code"), async (req, res) => {
  const code = fs.readFileSync(req.file.path, "utf8");
  const result = await analyzeCode(code);

  const report = {
    filename: req.file.originalname,
    result,
    timestamp: new Date().toISOString()
  };

  const reportPath = `reports/report-${Date.now()}.json`;
  fs.writeFileSync(reportPath, JSON.stringify(report, null, 2));

  res.render("result", { result });
});

app.listen(3000, () =>
  console.log("🚀 Server running on http://localhost:3000")
);
