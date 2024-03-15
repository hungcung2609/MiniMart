using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using WindowsFormsApp1.GdDangNhap;
using WindowsFormsApp1.Main;

namespace WindowsFormsApp1
{
    public partial class DangNhap : Form
    {
        public DangNhap()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            DangKy dangKy = new DangKy();
            dangKy.Show();
            this.Hide();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            Main.Main main = new Main.Main();
            main.Show();
            this.Hide();
        }

        private void label1_Click(object sender, EventArgs e)
        {

        }

        private void MiniMart_Load(object sender, EventArgs e)
        {

        }

        private void Tkhoan_TextChanged(object sender, EventArgs e)
        {

        }
    }
}
