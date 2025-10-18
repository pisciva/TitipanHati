// app/dashboard/admin/donasi/page.tsx
import Sidebar from "@/components/admin/sidebarAdmin/sidebar";
import Header from "@/components/admin/header/header";
import CalendarSection from "@/components/admin/calendarsection/calendarsection";
import DonationList from "@/components/admin/donationlist/donationlist";

export default function DonasiPage() {
  return (
    <div className="flex min-h-screen">
      <Sidebar />
      <main className="flex-1 p-10 bg-[#FAFAFA]">
        <Header />

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <CalendarSection />
          <DonationList />
        </div>
      </main>
    </div>
  );
}
