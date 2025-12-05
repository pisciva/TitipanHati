"use client";
import { TrendingUp, TrendingDown } from "lucide-react";

interface Props {
  title: string;
  value: string | number;
  icon: string;
  increase?: boolean;
}

export default function SummaryCard({ title, value, icon, increase }: Props) {
  return (
    <div className="flex items-center justify-between w-80 border rounded-2xl p-5 bg-white shadow-sm">
      <div className="flex items-center gap-3">
        <img src={icon} alt={title} className="w-10 h-10" />
        <div>
          <p className="text-gray-700 font-semibold">{title}</p>
          <h2 className="text-2xl font-bold">{value}</h2>
        </div>
      </div>

      <div
        className={`flex items-center gap-1 text-xs px-2 py-1 rounded-full ${
          increase ? "bg-green-100 text-green-700" : "bg-red-100 text-red-600"
        }`}
      >
        {increase ? (
          <TrendingUp className="w-3 h-3" />
        ) : (
          <TrendingDown className="w-3 h-3" />
        )}
        {increase ? "12%" : "12%"}
      </div>
    </div>
  );
}
