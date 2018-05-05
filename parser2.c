#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int isSlash(char *str);//return 1 if char is a '/' and 0 elsewisw
char* getX(char *str);//return the X value (in char)
char* getY(char *str);//return the Y value (in char)
char* getX2(char *str);//return the X2 value (in char) - it's the second point in the txt file
char* getY2(char *str);//return the Y2 value (in char) - it's the second point in the txt file
	
	/*********************************/
	/*	   debug print arr func		 */
	void printarrShip(int str[19][4]);
	/*********************************/

int main ( void )
{

	int arrShip[19][4];//holds all points of straight lines

	int shipCount=0;//counts the main index of the ship arr to set values


	char x[5]; //the x value before being convert into integer
	char y[5]; //the y value before being convert into integer

	

   static const char filename[] = "data.txt";
   FILE *file = fopen ( filename, "r" );
   if ( file != NULL )
   {
      char line [ 64 ]; /* or other suitable maximum line size */

      while ( fgets ( line, sizeof line, file ) != NULL ) /* read a line */
      {
         //fputs ( line, stdout ); /* write the line */
		  if(isSlash(line))
		  {
			  continue;
		  }
		    strcpy(x,getX(line));
			arrShip[shipCount][0]=atoi(x);
			strcpy(y,getY(line));
			arrShip[shipCount][1]=atoi(y);
			
			strcpy(x,getX2(line));
			if (strcmp( x, "r" ) == 0)
			{
				arrShip[shipCount][2]=-999;
			}
			else
			{
				arrShip[shipCount][2]=atoi(x);
			}
			strcpy(y,getY2(line));
			arrShip[shipCount][3]=atoi(y);
			
			shipCount++;
			
		  

      }
      fclose ( file );
   }
   else
   {
      perror ( filename ); /* why didn't the file open? */
   }
   
   printarrShip(arrShip);
	system("pause");
   return 0;
}

int isSlash(char *str)
{
	if (str[0]=='/')
		return 1;
	else
		return 0;
}
char* getX(char *str)
{
	int i=1;
	int j=0;
	char answer[5]={'\0'};
	while (str[i]!=',')
	{
		i++;
		answer[j]=str[i-1];
		j++;
	}
	
	return strdup(answer);
}
char* getY(char *str)
{
	int i=1;
	int j=0;
	char answer[5];
	while (str[i]!=',')
		i++;
	while (str[i]!=')')
	{
		i++;
		answer[j]=str[i];
		j++;
	}
	return strdup(answer);
}
char* getX2(char *str)
{
	int i=1;
	int j=0;
	char answer[5]={'\0'};
	while (str[i]!='(')
		i++;
	i++;
	while (str[i]!=',')
	{
		i++;
		answer[j]=str[i-1];
		j++;
	}
	
	return strdup(answer);
}
char* getY2(char *str)
{
	int i=1;
	int j=0;
	char answer[5];
	while (str[i]!='(')
		i++;
	while (str[i]!=',')
		i++;
	while (str[i]!=')')
	{
		i++;
		answer[j]=str[i];
		j++;
	}
	return strdup(answer);
}

void printarrShip(int str[19][4])
{
	int i;
	for (i=0;i<19;i++)
		printf("%d  %d  %d  %d \n",str[i][0],str[i][1],str[i][2],str[i][3]);
	printf("\n");
}
