#include <stdio.h>
#include <stdlib.h>

int main()
{
    int umur, jml_sdr, anakke, jml_anak;

    printf("Umur");
    scanf ("%d", &umur);

    printf("jml_sdr: ");
    scanf ("%d", &jml_sdr);

    printf("jml_ank: ");
    scanf ("%d", &jml_anak);

    jml_anak=jml_sdr+1;
    printf ("Saya Berumur %d, anakke %d, dari %d bersaudara",umur,anakke,jml_anak);
    return 0;
}