// app/dashboard/page.tsx
import Sidebar from "@/components/admin/sidebarAdmin/sidebar";
import Header from "@/components/admin/header/header";
import SummaryCard from "@/components/admin/summarycard/summarycard";

export default function DashboardIndex() {
  return (
    <div className="flex min-h-screen">
      <Sidebar />
      <main className="flex-1 p-10 bg-[#FAFAFA]">
        <Header />

        <div className="grid grid-cols-2 gap-8">
          <SummaryCard
            title="Campaign Aktif"
            value={78}
            icon="/icon-campaign.svg"
            increase
          />
          <SummaryCard
            title="Donasi Tersalurkan"
            value="3000+"
            icon="/icon-donasi.svg"
            increase={false}
          />
          <SummaryCard
            title="Campaign Aktif"
            value={78}
            icon="/icon-campaign.svg"
            increase
          />
          <SummaryCard
            title="Donasi Tersalurkan"
            value="3000+"
            icon="/icon-donasi.svg"
            increase={false}
          />
        </div>
      </main>
    </div>
  );
}
