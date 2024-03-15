namespace WindowsFormsApp1
{
    partial class DangNhap
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(DangNhap));
            this.button1 = new System.Windows.Forms.Button();
            this.button2 = new System.Windows.Forms.Button();
            this.Tkhoan = new System.Windows.Forms.TextBox();
            this.Mkhau = new System.Windows.Forms.TextBox();
            this.Hien = new System.Windows.Forms.CheckBox();
            this.User = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.Minimart = new System.Windows.Forms.PictureBox();
            ((System.ComponentModel.ISupportInitialize)(this.Minimart)).BeginInit();
            this.SuspendLayout();
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(17, 333);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(193, 58);
            this.button1.TabIndex = 0;
            this.button1.Text = "Đăng Ký";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(256, 333);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(193, 58);
            this.button2.TabIndex = 1;
            this.button2.Text = "Đăng Nhập";
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Click += new System.EventHandler(this.button2_Click);
            // 
            // Tkhoan
            // 
            this.Tkhoan.Location = new System.Drawing.Point(139, 156);
            this.Tkhoan.Multiline = true;
            this.Tkhoan.Name = "Tkhoan";
            this.Tkhoan.Size = new System.Drawing.Size(140, 41);
            this.Tkhoan.TabIndex = 2;
            this.Tkhoan.TextChanged += new System.EventHandler(this.Tkhoan_TextChanged);
            // 
            // Mkhau
            // 
            this.Mkhau.Location = new System.Drawing.Point(139, 225);
            this.Mkhau.Multiline = true;
            this.Mkhau.Name = "Mkhau";
            this.Mkhau.Size = new System.Drawing.Size(140, 41);
            this.Mkhau.TabIndex = 3;
            this.Mkhau.UseSystemPasswordChar = true;
            this.Mkhau.UseWaitCursor = true;
            // 
            // Hien
            // 
            this.Hien.AutoSize = true;
            this.Hien.Location = new System.Drawing.Point(139, 287);
            this.Hien.Name = "Hien";
            this.Hien.Size = new System.Drawing.Size(97, 17);
            this.Hien.TabIndex = 4;
            this.Hien.Text = "Hiện Mật Khẩu";
            this.Hien.UseVisualStyleBackColor = true;
            // 
            // User
            // 
            this.User.BackColor = System.Drawing.SystemColors.Control;
            this.User.Font = new System.Drawing.Font("Microsoft Sans Serif", 15F, System.Drawing.FontStyle.Bold);
            this.User.Location = new System.Drawing.Point(12, 156);
            this.User.MaximumSize = new System.Drawing.Size(100, 100);
            this.User.Name = "User";
            this.User.Size = new System.Drawing.Size(71, 41);
            this.User.TabIndex = 5;
            this.User.Text = "User";
            this.User.Click += new System.EventHandler(this.label1_Click);
            // 
            // label1
            // 
            this.label1.BackColor = System.Drawing.SystemColors.Control;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 15F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.Location = new System.Drawing.Point(12, 225);
            this.label1.MaximumSize = new System.Drawing.Size(1000, 1000);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(107, 41);
            this.label1.TabIndex = 6;
            this.label1.Text = "Password";
            // 
            // Minimart
            // 
            this.Minimart.Image = global::WindowsFormsApp1.Properties.Resources.minimart;
            this.Minimart.ImageLocation = "minimart.png";
            this.Minimart.Location = new System.Drawing.Point(-6, -115);
            this.Minimart.Name = "Minimart";
            this.Minimart.Size = new System.Drawing.Size(936, 528);
            this.Minimart.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.Minimart.TabIndex = 7;
            this.Minimart.TabStop = false;
            this.Minimart.UseWaitCursor = true;
            // 
            // GdDangnhap
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.SystemColors.ButtonHighlight;
            this.ClientSize = new System.Drawing.Size(632, 450);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.User);
            this.Controls.Add(this.Hien);
            this.Controls.Add(this.Mkhau);
            this.Controls.Add(this.Tkhoan);
            this.Controls.Add(this.button2);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.Minimart);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "GdDangnhap";
            this.Text = "Mini Mart";
            this.Load += new System.EventHandler(this.MiniMart_Load);
            ((System.ComponentModel.ISupportInitialize)(this.Minimart)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.Button button2;
        private System.Windows.Forms.TextBox Tkhoan;
        private System.Windows.Forms.TextBox Mkhau;
        private System.Windows.Forms.CheckBox Hien;
        private System.Windows.Forms.Label User;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.PictureBox Minimart;
    }
}

